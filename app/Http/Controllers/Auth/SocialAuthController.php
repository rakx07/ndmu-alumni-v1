<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        /** @noinspection PhpUndefinedMethodInspection */
        return $driver
            ->setHttpClient(new Client(config('socialite.guzzle')))
            ->redirect();
    }

    public function callback(string $provider)
    {
        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);

        /** @noinspection PhpUndefinedMethodInspection */
        $driver->setHttpClient(new Client(config('socialite.guzzle')));

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
