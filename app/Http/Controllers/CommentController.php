<?php

namespace App\Http\Controllers;

use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use App\Thread;

class CommentController extends Controller
{

    /**
     * @param Request $request
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Thread $thread)
    {

        $request->validate([
            'body' => 'required|max:255',
        ]);

        $thread->comments()->create([
            'body' => $request->body,
            'user_id' =>auth()->user()->id,
        ]);

        $thread->user->notify(new NewCommentNotification($thread));

        return redirect()->back()->with('success', 'Comment Posted successfully !');
    }


}
