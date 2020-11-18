<?php

namespace App\Http\Controllers;

use App\Models\{Wall};
use Auth;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function postWall(Request $request)
    {
        $this->validate(
            $request,
            [
                'wall' => 'required|max:1000'
            ]
        );

        Auth::user()->walls()->create(
            [
                'body' => $request->input('wall')
            ]
        );

        return redirect()
            ->route('home')
            ->with('info', 'Запис успішно доданий!');
    }

    public function postReply(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                "reply-{$id}" => 'required|max:1000'
            ],
            [
                'required' => "Поле обов'якове для заповнення"
            ]
        );

        $wall = Wall::notReply()->find($id);

        if (!$wall) {
            redirect()->route('home');
        }

        if (!Auth::user()->isFriendOf($wall->user)
            && Auth::user()->id !== $wall->user->id) {
            return redirect()->route('home');
        }

        $reply = new Wall();
        $reply->body = $request->input("reply-{$wall->id}");
        $reply->user()->associate(Auth::user());
        $wall->replies()->save($reply);

        return redirect()->back();
    }

    /**
     * post an like
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLike($id)
    {
        $wall = Wall::find($id);

        if (!$wall) {
            redirect()->route('home');
        }

        if (!Auth::user()->isFriendOf($wall->user)) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasLikedWall($wall)) {
            return redirect()->back();
        }

        $wall->likes()->create(['user_id' => Auth::user()->id]);

        return redirect()->back();
    }
}
