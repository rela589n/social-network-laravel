<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    # страница регистрации
    public function getSignup() 
    {
       return view('auth.signup');
    }

    # регистрация пользователя
    public function postSignup(Request $request) 
    {
       $this->validate($request, [
           'email' => 'required|unique:users|email|max:255',
           'username' => 'required|unique:users|alpha_dash|max:20',
           'password' => 'required|min:6',
       ]);

       User::create([
           'email' => $request->input('email'),
           'username' => $request->input('username'),
           'password' => bcrypt($request->input('password')),
       ]);

       return redirect()
              ->route('home')
              ->with('info', 'Вы успешно зарегистрировались! Можно войти на сайт.');
    }

    # страница входа
    public function getSignin() 
    {
       return view('auth.signin');
    }

    # вход пользователя на сайт
    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        if ( ! Auth::attempt( $request->only(['email', 'password']), $request->has('remember') ) )
        {
            return redirect()->back()->with('info', 'Неправильный логин или пароль.');
        }

        return redirect()->route('home')->with('info', 'Вы вошли на сайт.');
    }

    # выйти из аккаунта
    public function getSignout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
