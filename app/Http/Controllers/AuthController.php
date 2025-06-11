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

    public function activate(Request $request)
    {
        $auth = User::where('token', $request->token)->first();
        return view('auth.activate', [
            'token' => $request->token,
            'type' => $auth->role->label()
        ]);
    }

    public function activating(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if(\Hash::check($request->password, $user->password)) {
            $user->token = null;
            $user->blocked = false;
            $user->save();

            toastr()->addSuccess("Votre compte à bien été activer !");

            return redirect()->route('login');
        } else {
            return redirect()->back()->with('error', "Votre mot de passe est incorrect.");
        }
    }
}
