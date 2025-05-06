<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }


    public function forget_password() {
        return view('auth.forget_pw');
    }


    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)) {
            return redirect()->route('products.index');
        }
        return back()->withErrors(['username' => 'Invaid credentials']);
    }


    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'privilage' => 'required|in:user,admin'
        ]);

        User::create([
            'username' => $request->username,
            'password' => $request->password,
            'privilage' => $request->privilage
        ]);

        return redirect()->route('login')->with('success', 'Registered successfully');
    }
    
}
