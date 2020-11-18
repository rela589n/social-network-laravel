<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class FriendController extends Controller
{
    /**
     * my friends controller
     *
     * @return Application|Factory|View
     */
    public function getIndex()
    {
        return view(
            'friends.index',
            [
                'friends'  => Auth::user()->acceptedFriends(),
                'requests' => Auth::user()->friendRequests()
            ]
        );
    }

    /**
     * post friend request
     *
     * @param $username
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()
                ->route('home')
                ->with('info', 'Користувач не знайдений!');
        }

        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasFriendRequestPending($user)
            || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Запит в друзі вже відправлений!');
        }

        if (Auth::user()->isFriendOf($user)) {
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Користувач уже є вашим другом.');
        }

        Auth::user()->addFriend($user);

        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', 'Запит в друзі відправлено.');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()
                ->route('home')
                ->with('info', 'Користувача не знайдено');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', 'Запит в друзі прийнято');
    }

    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->isFriendOf($user)) {
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->with('info', 'Видалено з друзів.');
    }
}
