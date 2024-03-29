<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;


class LoginController extends Controller
{
    //Méthode d'appelle de la page de connexion
    public function login()
    {
        return view('Auth.login');
    }

    //Méthode de connexion
    public function connect(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (Auth::attempt($credentials)){
                $user = Auth::user();
                if ($user->isAdmin()){
                    $request->session()->regenerate();
                    return redirect()->intended(route('User.index'));
                }else {
                    $request->session()->regenerate();
                    return redirect()->intended(route('AffichagePresence'));
                }
            }else {
                return back()->withErrors([
                    'email' => 'Identifiants incorrects'
                ])->onlyInput('email');
            }
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    //Méthode de déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }


}
