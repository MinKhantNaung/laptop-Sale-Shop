<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Shop\Order;
use App\Models\Blog\Comment;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    // to toggle comment show/hide with ajax
    public function manageComment(Request $request) {
        $comment = Comment::find($request->commentId);

        // check status
        if ($comment->status == 'show') {
            $comment->update([
                'status' => 'hide',
            ]);

            return response()->json([
                'message' => 'hided'
            ]);
        }

        // if status is hide, change show
        $comment->update([
            'status' => 'show',
        ]);

        return response()->json([
            'message' => 'showed',
        ]);
    }
}
