<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        if ( Auth::check() ) {
            $statuses = Status::notReply()->where(function($query) {
                return $query->where('user_id', Auth::user()->id)
                  ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            return view('timeline.index', compact('statuses'));
        }

        $count_register_users = User::all()->count();

        return view('home', compact('count_register_users'));
    }
}
