<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\Rating;
use Illuminate\Http\Request;

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
}
