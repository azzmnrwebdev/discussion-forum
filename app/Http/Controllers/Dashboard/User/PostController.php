<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
        $user = Auth::user();
        $search = $request->input('q');

        $posts = Post::with(['user', 'category', 'likes'])->where('users_id', $user->id);

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

        return view('dashboard.page.user.my-post.index', compact('search', 'categoryColors', 'posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('dashboard.page.user.my-post.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $userLogin = Auth::user();
        $validatedData = Validator::make($request->all(), [
            'title'         => 'required|string',
            'categories_id' => 'required',
            'content'       => 'required|string'
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $post = Post::create([
            'users_id'      => $userLogin->id,
            'title'         => $request->input('title'),
            'categories_id' => $request->input('categories_id'),
            'content'       => $request->input('content'),
        ]);

        Image::where('posts_id', null)->update(['posts_id' => $post->id]);
        return redirect(route('posts.index'))->with('success', 'Postingan berhasil dibuat');
    }

    public function show($slug)
    {
        $user = Auth::user();
        $post = Post::with(['user', 'category', 'comments'])
                ->where('users_id', $user->id)
                ->where('slug', $slug)->firstOrFail();

        $likedUsers = $post->likes()->with('user')->orderBy('created_at', 'desc')->get()->pluck('user.name');
        $favoritedUsers = $post->favorites()->with('user')->orderBy('created_at', 'desc')->get()->pluck('user.name');

        $totalReplyComments = [];
        $totalComments = Comment::where('posts_id', $post->id)->count();

        foreach ($post->comments as $comment) {
            $totalReplyComments[$comment->id] = $comment->replies->count();
            foreach ($comment->replies as $reply) {
                $totalReplyComments[$comment->id] += $reply->replies->count();
            }
        }

        return view('dashboard.page.user.my-post.show', compact('post', 'likedUsers', 'favoritedUsers', 'totalComments', 'totalReplyComments'));
    }

    public function edit($id)
    {
        // belum dibuat
    }

    public function update(Request $request, $id)
    {
        // belum dibuat
    }

    public function destroy(Post $post)
    {
        if ($post->users_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }

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
