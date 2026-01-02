<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class SocialAuthController extends Controller
{
    /**
     * Redirect to provider (Google, etc.)
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback
     */
    public function callback(string $provider)
    {
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        // ✅ stateless() is valid — this annotation fixes Intelephense
        $socialUser = $driver->stateless()->user();

        $email = $socialUser->getEmail();

        // Safety check
        if (!$email) {
            abort(422, 'No email address returned by provider.');
        }

        // Check if user already exists
        $existingPassword = User::where('email', $email)->value('password');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $socialUser->getName()
                    ?: $socialUser->getNickname()
                    ?: 'Alumni User',

                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),

                // ✅ Required because password is NOT NULL
                // Will NOT overwrite password for normal registered users
                'password' => $existingPassword ?: Hash::make(Str::random(40)),
            ]
        );

        Auth::login($user);

        return redirect()->route('alumni.dashboard');
    }
}
