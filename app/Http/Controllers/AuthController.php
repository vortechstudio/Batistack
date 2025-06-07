<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, string $provider)
    {
        $social = Socialite::driver($provider)->stateless()->user();
        if (!$social) {
            return redirect('/login')->with('error', "Votre Compte $provider n'est pas reconnue par le service d'authentification.<br>Veuillez contacter un administrateur.");
        } else {
            $user = User::where('email', $social->email)->first();
            if (!$user) {
                return redirect('/login')->with('error', "Votre adresse mail n'est pas reconnue par le service d'authentification.<br>Veuillez contacter un administrateur.");
            } else {
                \Auth::login($user);
                return redirect()->route('core.dashboard');
            }
        }
    }
}
