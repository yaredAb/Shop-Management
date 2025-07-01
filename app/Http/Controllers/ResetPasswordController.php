<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request)
    {

        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ]
        ], $messages);

        $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();


        if(!$record || !Hash::check($request->token, $record->token)){
            return back()->withErrors(['token' => 'Invalid or expired token']);
        }



        if(Carbon::parse($record->cretaed_at)->addMinutes(60)->isPast()){
            return back()->withErrors(['token' => 'token expired']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return redirect()->route('login')->with('success', 'Password has been reset!');
    }
}
