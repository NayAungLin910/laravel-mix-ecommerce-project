<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with("error", "Email not found!");
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with("error", "Wrong password!");
        }

        auth()->login($user);

        return redirect('/')->with('success', "Welcome " . $user->name .  "!");
    }
    public function showRegister()
    {
        return view('auth.register');
    }
    public function postRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "image" => "required|mimes:png,jpg,webp",
            "phone" => "required",
            "address" => "required",
        ]);

        // check already email
        $findUser = User::where("email", $request->email)->first();
        if ($findUser) {
            return redirect()->back()->withErrors('error', "Email already Exist!");
        }

        $file = $request->file('image');
        $file_name = uniqid() .  $file->getClientOriginalName();
        $file_path = "/images/" . $file_name;
        $file->move(public_path('/images'), $file_name);

        $user = User::create([
            "image" => $file_path,
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone" => $request->phone,
            "address" => $request->address,
        ]);

        auth()->login($user);
        return redirect('/')->with('success', "Welcome " . $user->name .  "!");
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login')->with("info", "Please login again!");
    }
}
