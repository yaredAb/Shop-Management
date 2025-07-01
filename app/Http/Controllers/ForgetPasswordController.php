<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'cretaed_at' => now()
            ]
        );

        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::raw("Resete your password using this link: $resetLink", function($message) use ($request){
            $message->to($request->email)->subject('Reset Password Notification');
        });

        return back()->with('status', 'We have emailed your password reset link');
    }
}
