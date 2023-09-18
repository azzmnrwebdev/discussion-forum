<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoritedPosts = Post::whereHas('favorites', function ($query) use ($user) {
            $query->where('users_id', $user->id);
        })->orderBy('created_at', 'desc')->get();

        return view('dashboard.page.general.favorite.index', compact('favoritedPosts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with(['user', 'category', 'comments'])->firstOrFail();

        $user = Auth::user();
        $userLiked = $user->favorites->where('posts_id', $post->id)->first();

        if (!$userLiked) {
            abort(404);
        }

        $post->increment('views_count');

        $totalReplyComments = [];
        $totalComments = Comment::where('posts_id', $post->id)->count();

        foreach ($post->comments as $comment) {
            $totalReplyComments[$comment->id] = $comment->replies->count();
            foreach ($comment->replies as $reply) {
                $totalReplyComments[$comment->id] += $reply->replies->count();
            }
        }

        return view('dashboard.page.general.favorite.show', compact('post', 'totalComments', 'totalReplyComments'));
    }
}
