<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider; // ✅ ADD THIS

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        /** @var AbstractProvider $driver */ // ✅ CAST IS HERE
        $driver = Socialite::driver($provider);

        $socialUser = $driver->stateless()->user();

        // Use email as identity
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName()
                    ?: $socialUser->getNickname()
                    ?: 'Alumni User',
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]
        );

        Auth::login($user);

        return redirect()->route('alumni.dashboard');
    }
}
