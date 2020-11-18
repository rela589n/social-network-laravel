<?php

namespace App\Http\Controllers;

use App\Models\{User, Wall};
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $walls = Wall::notReply()->where(
                function ($query) {
                    return $query->where('user_id', Auth::user()->id)
                        ->orWhereIn('user_id', Auth::user()->acceptedFriends()->pluck('id'));
                }
            )
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('timeline.index', compact('walls'));
        }

        $count_reg_user = User::whereNotNull('email_verified_at')->count();

        return view('home', compact('count_reg_user'));
    }
}
