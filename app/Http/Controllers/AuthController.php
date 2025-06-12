<?php

namespace App\Http\Controllers;

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
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'privilage' => 'required|in:user,admin'
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'privilage' => $validated['privilage'],
        ]);

        Log::saveLog('Green', 'Account with username of '. $validated['username'] . ' is created  ');

        return redirect()->route('login')->with('success', 'Registered successfully');
    }

    public function securityQA(Request $request) {
        $request->validate([
            'security_question' => 'required|string',
            'security_answer' => 'required|string'
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['auth' => 'You must be logged in to set a security question.']);
        }

        $user->security_question = $request->security_question;
        $user->security_answer = $request->security_answer;
        $user->save();

        return redirect()->back()->with('success', 'Security question and answer saved');
    }

    public function updatePassword(Request $request) {
        $request->validate(['password' => 'required|min:6']);

        $user = Auth::user();

        if(!$user) {
            return redirect()->route('login')->withErrors(['auth' => 'You must be logged in to set a security question.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        Log::saveLog('Green', $user->username . '\'s password updated ');
        return redirect()->back()->with('success', 'Password Updated Successfully');
    }

    public function resetePassword(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        $user = User::where('username', $request->username)->first();

        if(!$user) {
            return redirect()->route('login')->withErrors(['auth' => 'No username provided.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login');
    }

}
