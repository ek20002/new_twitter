<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class TweetCommentsController extends Controller {

    /**
     *
     * CommentController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store( Tweet $tweet)
    {
        //$tweet = Tweet::findOrFail($id);

         $validated=$this->validate(request(), [
            'body' => 'required'
        ]);

        $tweet->addComment([
            'body' => $validated['body'],
            'user_id' => auth()->id()
        ]);

        return back();

    }
}
