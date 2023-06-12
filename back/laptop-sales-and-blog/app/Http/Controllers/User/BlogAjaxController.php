<?php

namespace App\Http\Controllers\User;

use App\Models\Blog\Like;
use App\Models\Blog\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

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

    public function comment(Request $request) {
        $comment = Comment::create([
            'post_id' => $request->postId,
            'user_id' => $request->userId,
            'comment' => $request->comment,
        ]);

        $user = $comment->user->name;
        $timeAgo = $comment->created_at->diffForHumans();

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'user' => $user,
            'timeAgo' => $timeAgo
        ]);
    }

    public function deleteComment(Request $request) {
        $comment = Comment::find($request->commentId);

        if (!Gate::allows('delete-comment', $comment)) {
            return response()->json([
                'success' => false,
            ]);
        }

        $comment->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
