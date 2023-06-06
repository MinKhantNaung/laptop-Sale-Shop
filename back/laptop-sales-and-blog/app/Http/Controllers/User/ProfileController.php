<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Shop\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // to profile index page
    public function index()
    {
        $brands = Brand::all();
        $user = Auth::user();

        return view('users.profile.index', compact('user', 'brands'));
    }

    // to profile edit page
    public function edit()
    {
        $brands = Brand::all();
        $user = Auth::user();

        return view('users.profile.edit', compact('user', 'brands'));
    }

    // to update profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|unique:users,email,' . auth()->user()->id,
            'image' => 'image|mimes:jpg,jpeg,png,svg,webp',
            'phone' => 'required|min:4|max:15',
            'address' => 'required',
            'gender' => 'required',
        ]);

        $user = User::find(auth()->user()->id);
        if ($request->hasFile('image')) {
            Storage::delete('public/user_image/' . $user->image);

            $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/user_image', $imageName);
        } else {
            // old image
            $imageName = $user->image;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageName,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);

        return redirect()->route('userProfile.index')->with('success', 'Profile updated successfully!');
    }

    // password change page
    public function passwordChange()
    {
        $brands = Brand::all();

        return view('users.profile.passwordChange', compact('brands'));
    }

    // to update password
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|max:20|same:confirm_password',
            'confirm_password' => 'required|string|min:8|max:20|same:new_password',
        ]);

        $user = User::find(auth()->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            // update password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            Auth::logout();
            return redirect()->route('login')->with('successMsg', 'Password has been changed successfully. Please log in with your new password!');
        } else {
            return back()->with('error', "The old password is incorrect!");
        }
    }
}
