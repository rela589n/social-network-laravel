<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Image;

class ProfileController extends Controller
{
    # страница профиля
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();
        
        # если пользователь не найден в базе
        if ( ! $user ) abort(404);

        $walls = $user->walls()->notReply()->latest()->get();

        return view('profile.index', [
            'user' => $user,
            'walls' => $walls,
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
            'location' => 'max:20',
            'gender' => 'required|string',
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
            'gender' => $request->input('gender'),
        ]);

        return redirect()
               ->route('profile.edit')
               ->with('info', 'Профиль успешно обновлен!');
    }

    # загрузка аватарки
    public function postUploadAvatar(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        # если пользователя нет в базе
        if ( ! $user ) return redirect()->route('home');

        # если это не наша страница
        if ( Auth::user()->id !== $user->id )
        {
            return redirect()->route('home');
        }

        if ( $request->hasFile('avatar') )
        {
            # удалить все аватарки в папке пользователя
            $user->clearAvatars($user->id);

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(300, 300)
                   ->save( public_path( $user->getAvatarsPath($user->id) ) . $filename );

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return redirect()->back();
    }
}
