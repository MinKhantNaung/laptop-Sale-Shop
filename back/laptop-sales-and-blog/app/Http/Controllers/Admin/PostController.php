<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // to posts page
    public function index()
    {
        $posts = Post::when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(6);
        $posts->appends(request()->all());

        return view('admin.blog.posts.index', compact('posts'));
    }

    // to post create page
    public function createPage()
    {
        $categories = Category::all();

        return view('admin.blog.posts.create', compact('categories'));
    }

    // to create post
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:80',
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/post_images', $imageName);

        Post::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.posts')->with('success', 'Post created!');
    }

    // to post edit page
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();

        return view('admin.blog.posts.edit', compact('post', 'categories'));
    }

    // to update post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:5|max:80',
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $post = Post::find($id);
        if ($request->hasFile('image')) {
            Storage::delete('public/post_images/' . $post->image);
            $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/post_images', $imageName);
        } else {
            $imageName = $post->image;
        }

        $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.posts')->with('warning', 'Post updated!');
    }

    // to delete post
    public function delete($id)
    {
        $post = Post::find($id);

        Storage::delete('public/post_images/' . $post->image);
        $post->delete();

        return back()->with('danger', 'Post deleted!');
    }

    // to post comments
    public function comments($id)
    {
        $post = Post::find($id);

        return view('admin.blog.posts.comments', compact('post'));
    }
}
