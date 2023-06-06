<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\Rating;
use Illuminate\Support\Str;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use App\Models\Shop\Order_list;
use App\Http\Controllers\Controller;

class ShopAjaxController extends Controller
{
    // to rate products
    public function rateProduct(Request $request)
    {
        // logger($request);
        $userId = auth()->user()->id;
        $isRated = Rating::where('product_id', $request->laptopId)
            ->where('user_id', $userId)
            ->first();

        if ($isRated) {
            // don't let user to rate
            return response()->json([
                'status' => 'fail'
            ]);
        } else {
            // let user to rate
            Rating::create([
                'product_id' => $request->laptopId,
                'user_id' => $userId,
                'rating' => $request->rating,
            ]);
            // to calculate average rating
            $product = Product::find($request->laptopId);
            $avgRating = number_format($product->users()->avg('rating'), 1);

            return response()->json([
                'status' => 'success',
                'productName' => $product->name,
                'avgRating' => $avgRating
            ]);
        }
    }

    // to add to cart with ajax
    public function addToCart(Request $request)
    {
        $laptop = Product::find($request->currentLaptopid);

        Cart::create([
            'product_id' => $request->currentLaptopid,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'message' => "You added $laptop->name to cart.",
        ]);
    }

    // to delete cart product when cross btn in cart page
    public function clearCartProduct(Request $request)
    {
        Cart::find($request->cartId)->delete();
    }

    // to add orderList after proceed to checkout
    public function proceedCheckout(Request $request)
    {
        // check $request is empty array?
        if (empty($request->all())) {
            return response()->json([
                'message' => 'emptyError'
            ]);
        } 

        // check each orders's quantity is equal to 0
        foreach($request->all() as $item) {
            if ($item['quantity'] == 0) {
                return response()->json([
                    'message' => 'quantityError'
                ]);
            }
        }

        // for add total to order table
        $total = 0;

        // delete from cart
        Cart::where('user_id', auth()->user()->id)->delete();
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'order_code' => $this->generateOrderCode(),
            'total' => 0,
        ]);

        foreach ($request->all() as $item) {
            // Add the order id to the $item array
            $item['order_id'] = $order->id;
            // add specific products that order to order_lists
            $data = Order_list::create($item);
            $total += $data->total;
        }

        // Update order total with calculated $total + shippng
        $order->update([
            'total' => $total + 2,
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    protected function generateOrderCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = Str::random(8, $characters);
        $orderCode = 'pos_' . $code;
        return $orderCode;
    }
}
