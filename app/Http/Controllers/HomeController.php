<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\{ Status, User };

class HomeController extends Controller
{
    public function index()
    {
      # если авторизован, показать view стены
      # выбрать и записи друзей на стене
      if ( Auth::check() ) {
        $statuses = Status::notReply()->where(function($query) {
            return $query->where('user_id', Auth::user()->id)
              ->orWhereIn('user_id', Auth::user()->friends()->pluck('id') );
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('timeline.index', compact('statuses') );
      }

      # количество зарегистрированных на сайте
      $count_register_users = User::all()->count();

      return view('home', compact('count_register_users') );
    }
}
