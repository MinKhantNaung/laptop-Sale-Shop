<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Shop\Order_list;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // to orders page
    public function orders() {
        $orders = Order::when(request('search'), function($query) {
            $query->where('users.name', 'like', '%' . request('search') . '%');
        })
        ->select('orders.*', 'users.name as user_name')
        ->leftJoin('users', 'users.id', 'orders.user_id')
        ->orderBy('id', 'desc')
        ->paginate(10);

        $orders->appends(request()->all());
        return view('admin.shop.orders.orders', compact('orders'));
    }

    //  to order detail
    public function detail($id) {
        $order = Order::find($id);
        $orderProducts = Order_list::select('order_lists.*', 'users.name as user_name', 'products.name as product_name', 'products.image as product_image')
                        ->leftJoin('users', 'users.id', 'order_lists.user_id')
                        ->leftJoin('products', 'products.id', 'order_lists.product_id')
                        ->where('order_id', $order->id)
                        ->get();

        return view('admin.shop.orders.order_products', compact('order', 'orderProducts'));
    }

    // to delete order
    public function delete($id) {
        Order::find($id)->delete();

        return back()->with('danger', 'Order deleted successfully!');
    }
}
