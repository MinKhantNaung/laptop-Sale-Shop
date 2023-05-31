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

        return view('users.welcome', compact('featured_laptops', 'rate_laptops'));
    }

    // to shop page
    public function shop()
    {
        $brands = Brand::take(6)->get();
        $laptops = Product::orderBy('updated_at', 'desc')->take(8)->get();

        return view('users.shop', compact('brands', 'laptops'));
    }

    // to shop laptop detail page
    public function shopDetail($id)
    {
        $laptop = Product::find($id);
        $related_laptops = Product::where('brand_id', $laptop->brand_id)->take(4)->get();

        return view('users.shop-detail', compact('laptop', 'related_laptops'));
    }

    // to all brands page when click view more
    public function allBrands()
    {
        $brands = Brand::all();

        return view('users.all-brands', compact('brands'));
    }

    // to all laptops page when click view more
    public function allLaptops()
    {
        $laptops = Product::orderBy('id', 'desc')->paginate(8);
        $laptops->appends(request()->all());

        return view('users.all-laptops', compact('laptops'));
    }
}
