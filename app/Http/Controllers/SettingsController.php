<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\UserHelper;

class SettingsController extends Controller
{
    public function showSetting() {
        if(UserHelper::userInfo()['privilage'] != 'admin') {
            Log::saveLog('red', UserHelper::userInfo()['username'] . ' is tried to access the settings page');
            return redirect('/');
        }
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function setTelegramToken(Request $request) {
        $request->validate([
            'bot_token' => 'required|string',
            'chat_id' => 'required|string',
        ]);

        Setting::setValue('telegram_bot_token', $request->bot_token);
        Setting::setValue('telegram_chat_id', $request->chat_id);

        return redirect()->back()->with('success', 'Telegram token saved.');
    }

    public function setTimer(Request $request) {
        $request->validate([
            'dailyHour' => 'required|date_format:H:i'
        ]);

        Setting::setValue('daily_hour', $request->dailyHour);

        return redirect()->back()->with('success', 'Alarm saved.');
    }

    public function updateCustemization(Request $request) {
        $request->validate([
            'background_color' => 'required|string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'site_title' => 'required|string',
            'button_color' => 'required|string',
            'does_expiry' => 'required|boolean',
            'does_country' => 'required|boolean'
        ]);

        Setting::setValue('background_color', $request->background_color);
        Setting::setValue('primary_color', $request->primary_color);
        Setting::setValue('secondary_color', $request->secondary_color);
        Setting::setValue('button_color', $request->button_color);
        Setting::setValue('site_title', $request->site_title);
        Setting::setValue('does_expiry', $request->does_expiry);
        Setting::setValue('does_country', $request->does_country);

        Log::saveLog('green', 'Settings customization updated');
        return redirect()->back()->with('success', 'Customization updated');
    }

    public function userList() {
        if(UserHelper::userInfo()['privilage'] == 'user') {
            return redirect('/');
        }
        $users = User::orderBy('created_at')->get();
        return view('auth.userList', compact('users'));
    }

    public function deleteUser(User $user) {
        $user->delete();
        Log::saveLog('green', 'User has been deleted');
        return redirect()->back();
    }
}
