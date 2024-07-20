<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('frontend.register.register');
    }

    public function register(RegisterRequest $request)
    {
        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time().'.'.$avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $avatarName);
            $avatarPath = $avatarName;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'id_country' => $request->id_country,
            'avatar' => $avatarPath,
            'level' => 0, 
        ]);

        // Save the user
        if ($user->save()) {
            return redirect()->route('login.form')->with('success', 'Registration successful!');
        } else {
            return redirect()->route('register.form')->with('error', 'Registration failed. Please try again.');
        }
    }
}
