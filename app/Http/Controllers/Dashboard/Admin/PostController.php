<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    private function getRandomColorPair()
    {
        $colorPairs = [
            ['background' => '#FF5733', 'text' => '#FFFFFF'],
            ['background' => '#33FF57', 'text' => '#000000'],
            ['background' => '#5733FF', 'text' => '#FFFFFF'],
            ['background' => '#00FFFF', 'text' => '#000000'],
            ['background' => '#FF33A8', 'text' => '#FFFFFF'],
        ];

        return $colorPairs[array_rand($colorPairs)];
    }

    public function index(Request $request)
    {
        $search = $request->input('q');
        $posts = Post::with(['user', 'category']);

        if (!empty($search)) {
            $posts->where('title', 'like', "%$search%");
        }

        $categoryColors = [];
        $posts = $posts->orderByDesc('created_at')->get();

        foreach ($posts as $post) {
            $category = $post->category->name;
            if (!isset($categoryColors[$category])) {
                $colorPair = $this->getRandomColorPair();
                $categoryColors[$category] = [
                    'background' => $colorPair['background'],
                    'text' => $colorPair['text'],
                ];
            }
        }

        return view('dashboard.page.admin.posts.index', compact('search', 'categoryColors', 'posts'));
    }

    public function show($username, $slug)
    {
        $post = Post::with(['user', 'category', 'comments'])->whereHas('user', function ($query) use ($username) {
            $query->where('username', $username);
        })->where('slug', $slug)->firstOrFail();

        $likedUsers = $post->likes()->with('user')->orderBy('created_at', 'desc')->get()->pluck('user.name');
        $favoritedUsers = $post->favorites()->with('user')->orderBy('created_at', 'desc')->get()->pluck('user.name');
        $recentPosts = Post::where('users_id', $post->users_id)->where('id', '!=', $post->id)->orderBy('created_at', 'desc')->get();

        $totalReplyComments = [];
        $totalComments = Comment::where('posts_id', $post->id)->count();

        foreach ($post->comments as $comment) {
            $totalReplyComments[$comment->id] = $comment->replies->count();
            foreach ($comment->replies as $reply) {
                $totalReplyComments[$comment->id] += $reply->replies->count();
            }
        }

        return view('dashboard.page.admin.posts.show', compact('post', 'likedUsers', 'favoritedUsers', 'recentPosts', 'totalComments', 'totalReplyComments'));
    }

    public function destroy(Post $post)
    {
        $images = Image::where('posts_id', $post->id)->get();
        foreach ($images as $image) {
            $pathFile = public_path('storage/posts/' . $image->folder . '/' . $image->image);
            if (File::exists($pathFile)) {
                File::delete($pathFile);
                rmdir(public_path('storage/posts/' . $image->folder));
            }
        }

        $post->delete();
        return redirect()->back()->with('success', 'Postingan berhasil dihapus');
    }
}
