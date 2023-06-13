<?php

namespace App\Http\Controllers;

use App\Models\Blog\Category;
use App\Models\Contact;
use App\Models\Blog\Post;
use App\Models\Shop\Brand;
use App\Models\Shop\Product;
use App\Models\User;

use function Ramsey\Uuid\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        return $this->middleware('noAdmin');
    }

    // to welcome page or home page
    public function index()
    {
        $brands = Brand::all();
        // featured laptops
        $featured_laptops = Product::orderBy('discount', 'desc')->take(4)->get();
        // top rated laptops
        $rate_laptops = Product::select('products.*')
            ->selectSub(
                'SELECT AVG(rating) FROM ratings WHERE product_id = products.id',
                'average_rating'
            )
            ->orderBy('average_rating', 'desc')
            ->take(4)
            ->get();
        // posts from blog that have most comments
        $posts = Post::withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->take(3)
                ->get();

        return view('users.welcome', compact('featured_laptops', 'rate_laptops', 'brands', 'posts'));
    }

    // to shop page
    public function shop()
    {
        $brands = Brand::all();
        $brandsFilter = Brand::take(6)->get();
        $laptops = Product::orderBy('updated_at', 'desc')->take(8)->get();

        return view('users.shop', compact('brands', 'brandsFilter', 'laptops'));
    }

    // to shop laptop detail page
    public function shopDetail($id)
    {
        $brands = Brand::all();
        $laptop = Product::find($id);
        $related_laptops = Product::where('brand_id', $laptop->brand_id)
            ->whereNotIn('id', [$laptop->id])
            ->take(4)
            ->get();

        return view('users.shop_detail', compact('brands', 'laptop', 'related_laptops'));
    }

    // to all brands page when click view more
    public function allBrands()
    {
        $brands = Brand::all();

        return view('users.all_brands', compact('brands'));
    }

    // to all laptops page when click view more
    public function allLaptops()
    {
        $brands = Brand::all();
        $laptops = Product::orderBy('id', 'desc')->paginate(8);
        $laptops->appends(request()->all());

        return view('users.all_laptops', compact('brands', 'laptops'));
    }

    // to search laptops by clicking brand
    public function searchByBrand($id)
    {
        $brands = Brand::all();

        $laptops = Product::where('brand_id', $id)
            ->paginate(6);
        $laptops->appends(request()->all());

        return view('users.search_laptops', compact('brands', 'laptops'));
    }

    // to search laptops in search bar
    public function searchLaptops(Request $request)
    {
        $brands = Brand::all();
        // filter
        $laptops = Product::query();

        if ($request->latestPopular == 'latest') {
            $laptops->orderBy('id', 'desc');
        }

        if ($request->latestPopular == 'popular') {
            $laptops->select('products.*')
                ->selectSub(
                    'SELECT AVG(rating) FROM ratings WHERE product_id = products.id',
                    'average_rating'
                )
                ->orderBy('average_rating', 'desc');
        }

        if ($request->query('name')) {
            $laptops->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->query('min')) {
            $laptops->where('discount_price', '>=', $request->query('min'));
        }

        if ($request->query('max')) {
            $laptops->where('discount_price', '<=', $request->query('max'));
        }

        if ($request->query('brand_id')) {
            $laptops->where('brand_id', $request->query('brand_id'));
        }

        if ($request->query('condition')) {
            if ($request->query('condition') == 'new') {
                $laptops->where('condition', 'new');
            } else {
                $laptops->where('condition', 'second');
            }
        }

        if ($request->query('status')) {
            if ($request->query('status') == 'yes') {
                $laptops->where('status', 'yes');
            } else {
                $laptops->where('status', 'no');
            }
        }

        if ($request->query('search')) {
            $laptops->where('name', 'like', '%' . $request->query('search') . '%');
        }

        $laptops = $laptops->paginate(6);
        $laptops->appends(request()->all());

        return view('users.search_laptops', compact('brands', 'laptops'));
    }

    // Contact
    // to contact page
    public function contact() {
        $brands = Brand::all();
        $contacts = Contact::all();

        return view('users.contact', compact('brands', 'contacts'));
    }

    // Blog
    // to blogs page
    public function blog() {
        $brands = Brand::all();
        $categories = Category::all();
        $posts = Post::paginate(4);
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();

        return view('users.blog', compact('brands', 'categories', 'posts', 'recentPosts'));
    }

    // to search posts by category
    public function searchByCategory($id) {
        $brands = Brand::all();
        $categories = Category::all();
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();
        $posts = Post::where('category_id', $id)->paginate(4);
        $posts->appends(request()->all());

        return view('users.blog', compact('brands', 'categories', 'posts', 'recentPosts'));
    }

    // to search posts with input
    public function searchPosts() {
        $brands = Brand::all();
        $categories = Category::all();
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();
        // filter search
        $posts = Post::when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(4);
        $posts->appends(request()->all());

        return view('users.blog', compact('brands', 'categories', 'posts', 'recentPosts'));
    }

    // to post detail page
    public function postDetail($id) {
        $brands = Brand::all();
        $categories = Category::all();
        $recentPosts = Post::orderBy('updated_at', 'desc')->take(3)->get();
        // post detail
        $post = Post::find($id);
        $comments = $post->comments->where('status', 'show');

        return view('users.blog_detail', compact('brands', 'categories', 'recentPosts', 'post', 'comments'));
    }
}
