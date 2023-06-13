<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Blog\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // to categories index page
    public function index()
    {
        $categories = Category::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(6);

        $categories->appends(request()->all());

        return view('admin.blog.categories.index', compact('categories'));
    }

    // to category create page
    public function createPage()
    {
        return view('admin.blog.categories.create');
    }

    // to create category
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created!');
    }

    // to category edit page
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.blog.categories.edit', compact('category'));
    }

    // to update category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:30',
        ]);

        Category::find($id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('warning', 'Category updated!');
    }

    // to delete category
    public function delete($id)
    {
        $category = Category::find($id);

        // Delete the images of related posts
        foreach($category->posts as $post) {
            Storage::delete('public/post_images/' . $post->image);
        }
        $category->posts()->delete();
        $category->delete();

        return back()->with('danger', 'Category deleted!');
    }
}
