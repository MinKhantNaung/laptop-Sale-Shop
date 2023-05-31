<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
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
}
