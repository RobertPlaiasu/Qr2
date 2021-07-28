<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackGoogle()
    {
        $userGoogle = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            [
                'email' => $userGoogle->getEmail(),
            ],
            [
                'provider_id' => $userGoogle->getId(),
                'email' => $userGoogle->getEmail(),
                'name' => $userGoogle->getName(),
            ]);

        auth()->login($user,false);
        return redirect('/dashboard');
    }


}
