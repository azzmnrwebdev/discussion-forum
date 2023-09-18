<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function like(Post $post)
    {
        $user = Auth::user();
        $existingLike = Like::where('users_id', $user->id)->where('posts_id', $post->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return redirect()->back()->with('success', 'Anda berhasil membatalkan suka pada postingan ini!');
        } else {
            Like::create([
                'users_id' => $user->id,
                'posts_id' => $post->id
            ]);

            return redirect()->back()->with('success', 'Anda berhasil menyukai postingan ini!');
        }
    }

    public function favorite(Post $post)
    {
        $user = Auth::user();
        $existingFavorite = Favorite::where('users_id', $user->id)->where('posts_id', $post->id)->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return redirect()->back()->with('success', 'Anda berhasil membatalkan simpan pada postingan ini!');
        } else {
            Favorite::create([
                'users_id' => $user->id,
                'posts_id' => $post->id
            ]);

            return redirect()->back()->with('success', 'Anda berhasil menyimpan postingan ini!');
        }
    }
}
