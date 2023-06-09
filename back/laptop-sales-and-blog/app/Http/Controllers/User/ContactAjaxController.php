<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ContactAjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // to storing message from contact form with ajax
    public function messageAccept(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email',
            'message' => 'required|min:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'error' => $validator->errors()
            ]);
        }

        $user = User::find(auth()->user()->id);
        if ($request->email != $user->email) {
            return response()->json([
                'message' => 'invalid',
                'error' => 'The provided email does not match your authenticated email.',
            ]);
        }

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Message sent successfully!',
        ]);
    }
}
