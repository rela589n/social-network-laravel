<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\{ User, Status};
use Illuminate\Http\Request;

class StatusController extends Controller
{
    # опубликовать запись на стене
    public function postStatus(Request $request)
    {
      $this->validate($request, [
        'status' => 'required|max:1000'
      ]);

      Auth::user()->statuses()->create([
        'body' => $request->input('status')
      ]);

      return redirect()
        ->route('home')
        ->with('info', 'Запись успешно добавлена!');
    }

    # опубликовать комментарий к записи на стене
    public function postReply(Request $request, $statusId)
    {
      $this->validate($request, [
          "reply-{$statusId}" => 'required|max:1000'
      ], [
          'required' => 'Обязательно для заполнения'
      ]);

      $status = Status::notReply()->find($statusId);

      # если записи нет в базе
      if ( ! $status ) redirect()->route('home');

      if ( ! Auth::user()->isFriendWith($status->user)
            && Auth::user()->id !== $status->user->id ) {
        return redirect()->route('home');
      }

      $reply = new Status();
      $reply->body = $request->input("reply-{$status->id}");
      $reply->user()->associate( Auth::user() );
      $status->replies()->save($reply);

      return redirect()->back();
    }

    # поставить лайк
    public function getLike($statusId)
    {
      $status = Status::find($statusId);

      # если записи нет в базе
      if ( ! $status ) redirect()->route('home');

      # если пользователь не в друзьях
      if ( ! Auth::user()->isFriendWith($status->user) ) {
        return redirect()->route('home');
      }

      # если запись уже пролайкана
      if ( Auth::user()->hasLikedStatus($status) ) {
        return redirect()->back();
      }

      # лайкнуть запись
      $status->likes()->create(['user_id' => Auth::user()->id ]);

      return redirect()->back();
    }
}
