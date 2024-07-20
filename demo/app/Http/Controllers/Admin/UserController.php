<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function user()
    {
        $user = Auth::user();
        return view('admin.user.user', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->id_country = $request->id_country;

    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $avatarName = time().'.'.$avatar->getClientOriginalExtension();
        $avatar->move(public_path('avatars'), $avatarName);
        $user->avatar = $avatarName;
    }

    if ($user->level != 1) {
        $user->level = 1; 
    }

        $user->save();

        return redirect()->route('user')->with('success', 'Profile updated successfully');
    }
}
