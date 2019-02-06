<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class TweetsController extends Controller
{

    /**
     * TweetsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::all();

        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        auth()->user()->addTweet($validated);

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //$tweet = Tweet::findOrFail($id);
        //dd($tweet);
        return view('tweets.show', [
            'tweet' => $tweet,
            'comments' => $tweet->comments
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //$tweet = Tweet::findOrFail($id);
        //dd($tweet);
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tweet $tweet)
    {
        $validated = request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        //Tweet::findOrFail($id)->update($validated);
        $tweet->update($validated);

        return redirect()->route('tweets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        //Tweet::findOrFail($id)->delete();
        //dd($tweet);
        $tweet->delete();
        return redirect()->route('tweets.index');
    }
}
