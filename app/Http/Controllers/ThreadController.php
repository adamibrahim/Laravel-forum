<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Thread;

class ThreadController extends Controller
{

    /**
     * return the threads view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orderBy = 'created_at';
        $orderType = 'desc';

        if (request('orderBy')) {$orderBy = request('orderBy');}
        if (request('orderType')) {$orderType = request('orderType');}

        $threads = Thread::orderBy($orderBy, $orderType)->get();

        $authors = User::whereHas('threads')->get();

        $users_filter = collect([]);

        if (session()->has('users_filter') && count(session()->get('users_filter'))){
            $session_filters =  session()->get('users_filter');
            $authors = $authors->whereNotIn('id', $session_filters);
            $users_filter = User::whereIn('id', $session_filters)->get();
            $threads = $threads->whereIn('user_id', $session_filters);
        }

        return view('threads')
            ->with('threads', $threads)
            ->with('authors', $authors)
            ->with('users_filter', $users_filter);
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Thread $thread)
    {
        $collaborators = $thread->comments()->pluck('user_id')->push($thread->user->id)->unique();
        $collaborators = User::whereIn('id', $collaborators)->get();
        return view('thread')
            ->with('thread', $thread)
            ->with('collaborators', $collaborators);
    }

    /**
     * @param Request $request
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Thread $thread)
    {

        $request->validate([
            'title' => 'required|min:3|unique:threads,title,'.$thread->id.'|regex:/^[A-Za-z\s-_]+$/',
            'body' => 'nullable|max:255|regex:/\.$/',
        ]);

        $thread->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'Thread updated successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'title' => 'required|min:3|unique:threads|regex:/^[A-Za-z\s-_]+$/',
            'body' => 'nullable|max:255|regex:/\.$/',
        ]);

        $user->threads()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($user->threads()->count() > 5){
           $this->destroy($user->threads()->oldest()->first());
        }

        return redirect()->back()->with('success', 'Thread created successfully !');
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Thread $thread)
    {

        $user = auth()->user();

        if ($user->id !== $thread->user_id && !$user->isAdmin()){
            return redirect()->back()->with('danger', 'You have to access to this function');
        }

        $thread->comments()->delete();
        $thread->delete();
        return redirect()->back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFilterPush(Request $request)
    {
        $request->validate([
            'user_id' => 'required | numeric'
        ]);

        $request->session()->push('users_filter', $request->user_id);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userFilterForget(Request $request)
    {
        $request->validate([
            'user_id' => 'required | numeric'
        ]);

        if (!session()->has('users_filter')) {
            return redirect()->back();
        }

        foreach (Session()->get('users_filter') as $key => $value)
        {
            if ($value === $request->user_id)
            {
                Session()->pull('users_filter.'.$key);
                break;
            }
        }

        return redirect()->back();
    }


}
