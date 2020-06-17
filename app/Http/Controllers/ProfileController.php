<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    # страница профиля или ошибка, если пользователь не найден
    public function getProfile($username)
    {
       $user = User::where('username', $username)->first();
       if ( ! $user ) abort(404);

       $statuses = $user->statuses()->notReply()->get();

       return view('profile.index', [
           'user' => $user,
           'statuses' => $statuses,
           'authUserIsFriend' => Auth::user()->isFriendWith($user)
       ]);
    }

    # страница редактирования профиля
    public function getEdit()
    {
        return view('profile.edit');
    }

    # отредактировать профиль
    public function postEdit(Request $request) 
    {
        $this->validate($request, [
            'first_name' => 'alpha|max:50',
            'last_name' => 'alpha|max:50',
            'location' => 'max:20'
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location')
        ]);

        return redirect()
               ->route('profile.edit')
               ->with('info', 'Профиль успешно обновлен!');
    }
}
