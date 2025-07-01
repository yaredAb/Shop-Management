<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }


    public function forget_password(Request $request) {
        $request->validate([
            'username' => 'required|string'
        ]);

        $user = User::where('username', $request->username)->first();
        return view('auth.forget_pw', compact('user'));
    }

    public function username_entry() {
        return view('auth.username_entry');
    }

    public function validate_answer(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'answer' => 'required|string'
        ]);

        $username = $request->username;
        $answer = $request->answer;

        $user = User::where('username', $username)->first();

        if(!$user) {
            return redirect()->back()->with('error', 'Username required', compact('user'));
        }

        if(strcasecmp($answer, $user->security_answer) === 0) {
            return view('auth.reset_password', compact('user'));
        } else {
            return redirect()->back()->with('error', 'Invalid answer for the question', compact('user'));
        }
    }


    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::saveLog('green', $request->username . ' is Logged In.');
            return redirect()->route('products.index');
        }
        Log::saveLog('red', $request->username . ' is tried to log in with invalid credentials');
        return back()->withErrors(['username' => 'Invalid credentials']);
    }


    public function register(Request $request) {

        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];

        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            'privilage' => 'required|in:user,admin,cashier'
        ], $messages);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'privilage' => $validated['privilage'],
        ]);

        Log::saveLog('Green', 'Account with username of '. $validated['username'] . ' is created  ');
        event(new UserRegistered($user));

        return redirect()->route('login')->with('success', 'Registered successfully');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::id();
        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
        ];
        $request->validate(['password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ]
        ], $messages);

        User::where('id', $user)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password Updated successfully');
    }



}
