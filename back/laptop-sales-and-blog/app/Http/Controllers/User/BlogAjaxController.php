<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog\Like;
use Illuminate\Http\Request;

class BlogAjaxController extends Controller
{
    // like with ajax
    public function like(Request $request)
    {
        // check user is already liked
        $userLiked = Like::where('user_id', $request->userId)
            ->where('post_id', $request->postId)
            ->first();

        if($userLiked) {
            return response()->json([
                'message' => 'fail'
            ]);
        }

        Like::create([
            'post_id' => $request->postId,
            'user_id' => $request->userId,
        ]);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
