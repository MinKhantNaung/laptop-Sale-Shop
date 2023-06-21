<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // to contact page
    public function index()
    {
        $contacts = Contact::all();

        return view('admin.contact.index', compact('contacts'));
    }

    // to create contact page
    public function createContactPage()
    {
        return view('admin.contact.createContact');
    }

    // to create contact
    public function createContact(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:4|max:15',
            'email' => 'required|unique:users,email',
            'address' => 'required',
            'open_time' => 'required',
            'close_time' => 'required|after:open_time',
            'coordinates' => 'required',
        ]);

        // to get values separately in coordinates
        $values = explode(',', $request->coordinates);
        $latitude = $values[0];
        $longitude = $values[1];

        Contact::create([
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return redirect()->route('admin.contact')->with('success', 'Contact created successfully!');
    }

    // to edit contact
    public function editContact($id) {
        $contact = Contact::find($id);
        $coordinates = $contact->latitude . ',' . $contact->longitude;
        return view('admin.contact.editContact', compact('contact', 'coordinates'));
    }

    // to update contact
    public function updateContact(Request $request, $id) {
        $request->validate([
            'phone' => 'required|min:4|max:15',
            'email' => 'required|unique:users,email|unique:contacts,email,' . $id,
            'address' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            'coordinates' => 'required',
        ]);

        // to get values separately in coordinates
        $values = explode(',', $request->coordinates);
        $latitude = $values[0];
        $longitude = $values[1];

        Contact::find($id)->update([
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return redirect()->route('admin.contact')->with('warning', 'Contact updated successfully!');
    }

    // to messages page
    public function viewMessages()
    {
        $messages = Message::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('message', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(5);
        $messages->appends(request()->all());

        return view('admin.contact.messages', compact('messages'));
    }

    // to delete message
    public function deleteMessage($id)
    {
        Message::find($id)->delete();
        return back()->with('danger', 'Message deleted successfully!');
    }
}
