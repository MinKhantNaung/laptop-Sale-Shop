<?php

namespace App\Http\Controllers;

use App\Models\Shop\Brand;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('noAdmin');
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

        return view('users.welcome', compact('featured_laptops', 'rate_laptops', 'brands'));
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
}
