<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $query  = Category::withCount('posts');

        if (!empty($search)) $query->where('name', 'LIKE', '%' . $search . '%');
        $categories = $query->orderBy('created_at', 'desc')->get();

        return view('dashboard.page.admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('dashboard.page.admin.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'))
        ]);

        return redirect(route('categories.index'))->with('success', 'Data kategori berhasil disimpan');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('dashboard.page.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        return redirect(route('categories.index'))->with('success', 'Data kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return redirect()->back()->with('error', 'Kategori sedang digunakan dalam data postingan dan tidak dapat dihapus');
        } else {
            $category->delete();
            return redirect()->back()->with('success', 'Data kategori berhasil dihapus');
        }
    }
}
