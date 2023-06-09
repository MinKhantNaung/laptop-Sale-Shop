<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // to contact page
    public function index() {
        return view('admin.contact.index');
    }

    // to messages page
    public function viewMessages() {
        $messages = Message::when(request('search'), function($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('message', 'like', '%' . request('search') . '%');
        })
        ->orderBy('id', 'desc')->paginate(5);
        $messages->appends(request()->all());

        return view('admin.contact.messages', compact('messages'));
    }

    // to delete message
    public function deleteMessage($id) {
        Message::find($id)->delete();
        return back()->with('danger', 'Message deleted successfully!');
    }
}
