<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'string|max:300',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'users_id' => Auth::user()->id,
            'posts_id' => $request->input('posts_id'),
            'content'  => $request->input('content')
        ]);

        return redirect()->back()->with('comment_success', 'Comment successfully added');
    }

    public function reply(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'string|max:300',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'users_id'   => Auth::user()->id,
            'posts_id'   => $request->input('posts_id'),
            'parents_id' => $comment->id,
            'content'    => $request->input('content')
        ]);

        return redirect()->back()->with('comment_success', 'Reply comment successfully added');
    }
}
