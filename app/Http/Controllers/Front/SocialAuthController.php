<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Provider;
use App\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends FrontBaseController
{

    public function callback($provider)
    {

        $user = $this->createOrGetUser(Socialite::driver($provider));
        dd($user);
        /*auth()->login($user);*/

        return redirect()->to('/');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->scopes(['r_fullprofile'])->redirect();
    }

    private function createOrGetUser(Provider $provider)
    {
        $providerUser = $provider->user();
        return $providerUser;
        /*dd($providerUser);*/

        $providerName = class_basename($provider);

        $user = User::whereProvider($providerName)
            ->whereProviderId($providerUser->getId())
            ->first();

        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'provider_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);
        }

        return $user;
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}