<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // to categories index page
    public function index()
    {
        $categories = Category::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(6);

        return view('admin.blog.categories.index', compact('categories'));
    }

    // to category create page
    public function createPage() {
        return view('admin.blog.categories.create');
    }

    // to create category
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|min:2|max:30',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created!');
    }

    // to category edit page
    public function edit($id) {
        $category = Category::find($id);
        return view('admin.blog.categories.edit', compact('category'));
    }

    // to update category
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:2|max:30',
        ]);

        Category::find($id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('warning', 'Category updated!');
    }

    // to delete category
    public function delete($id) {
        $category = Category::find($id);
        $category->posts()->delete();
        $category->delete();

        return back()->with('danger', 'Category deleted!');
    }
}