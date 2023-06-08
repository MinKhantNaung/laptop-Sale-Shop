<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAjaxController extends Controller
{
    // to change product status with ajax
    public function changeStatus(Request $request)
    {
        // logger($request);
        if ($request->checked == 'true') {
            $status = 'yes';
        } else {
            $status = 'no';
        }

        Product::find($request->productId)->update([
            'status' => $status,
        ]);
    }

    // to change order status with ajax
    public function orderStatus(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->update([
            'status' => $request->status
        ]);
    }

    // to change role with ajax
    public function changeRole(Request $request) {
        $user = User::find($request->userId);
        $user->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
