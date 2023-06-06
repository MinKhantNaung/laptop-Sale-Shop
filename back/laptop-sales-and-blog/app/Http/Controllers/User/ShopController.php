<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Shop\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\Product;

class ShopController extends Controller
{
    // to cart page
    public function cartPage()
    {
        $brands = Brand::all();
        $cartProducts = Cart::select('carts.*', 'products.image as product_image', 'products.name as product_name', 'products.discount_price as product_price')
            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
            ->where('user_id', auth()->user()->id)
            ->get();

        // to calculate total
        $total = 0;
        foreach ($cartProducts as $cart) {
            $total += $cart->quantity * $cart->product_price;
        }

        return view('users.shop_checkout.cart', compact('brands', 'cartProducts', 'total'));
    }

    // to checkout page
    public function checkout()
    {
        $brands = Brand::all();
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return view('users.shop_checkout.checkout', compact('brands', 'orders'));
    }
}
