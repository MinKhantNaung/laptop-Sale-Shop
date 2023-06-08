<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // to profile page
    public function index()
    {
        $user = Auth::user();

        return view('admin.profile.index', compact('user'));
    }

    // to profile edit page
    public function edit()
    {
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
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
            Storage::delete('public/admin_image/' . $user->image);

            $imageName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/admin_image', $imageName);
        } else {
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

        return redirect()->route('adminProfile.index')->with('success', 'Profile updated successfully!');
    }

    // to password change page
    public function passwordChange()
    {
        return view('admin.profile.passwordChange');
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

    // to users list page
    public function usersList()
    {
        $users = User::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%');
        })
            ->orderBy('id', 'desc')->paginate(10);

        $users->appends(request()->all());
        return view('admin.users.list', compact('users'));
    }

    // to admins list with role admin
    public function adminsList() {
        $users = User::where('role', 'admin')->paginate(10);
        return view('admin.users.list', compact('users'));
    }

    // to users list with role user
    public function normalUsers() {
        $users = User::where('role', 'user')->paginate(10);
        return view('admin.users.list', compact('users'));
    }

    // to create user page by admin
    public function createUserPage() {
        return view('admin.users.createUser');
    }

    // to create user by admin
    public function createUser(Request $request) {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'phone' => 'required|min:4|max:15',
            'address' => 'required',
            'gender' => 'required',
            'password' => 'required|string|min:8|max:20|same:confirmPassword',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.usersList')->with('success', 'You created a user successfully!');
    }
}
