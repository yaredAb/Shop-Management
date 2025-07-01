@extends('layouts.app')

@section('content')
    <div class="setting-wrapper">
        <h2 class="title">Settings</h2>
        <div class="setting-container">
            <div class="setting-main">
                <div class="account-setting">
                    {{-- Account setting --}}
                    <h3 class="text-lg font-semibold">Account Setting</h3>
                    <form action="{{route('updatePassword')}}" method="POST" class="account-form">
                        @csrf
                        <label for="username">Username</label>
                        <input type="text" id="username" value="{{$user->username}}" disabled>
                        <p>Change Password</p>
                        @error('password')
                            <span class="text-red-700 font-semibold text-sm">{{$message}}</span>
                        @enderror
                        @if(session('success'))
                            <span class="text-green-700 font-semibold text-sm">{{session('success')}}</span>
                        @endif
                        <input type="password" name="password" id="password">
                        <button>Update</button>
                    </form>

                    {{-- Telegram notification keys --}}
                    <h3 class="text-lg font-semibold mt-5">Telegram keys</h3>
                    <form action="{{route('settings.setTelegramToken')}}" class="account-form" method="POST">
                        @csrf
                        <label for="bot_token">Bot Token</label>
                        <input type="password" name="bot_token" id="bot_token" value="{{ \App\Models\Setting::getValue('telegram_bot_token') }}">
                        <label for="chat_id">Chat Id</label>
                        <input type="text" name="chat_id" id="chat_id" value="{{ \App\Models\Setting::getValue('telegram_chat_id') }}">
                        <button type="submit">Save</button>
                    </form>
                    {{-- Small functionalities setup --}}
                    <h3 class="text-lg font-semibold mt-5">Time Setup to recieve daily report at telegram</h3>
                    <form action="{{route('settings.setTimer')}}" class="account-form" method="POST">
                        @csrf

                        <input type="time" name="dailyHour" id="dailyHour" value="{{\App\Models\Setting::getValue('daily_hour')}}">
                        <div class="form-inline">
                            <button type="submit">Set</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="setting-main">
                <h3 class="text-lg font-semibold">Site Customization</h3>
                <form action="{{route('settings.updateCustemization')}}" class="color-form" method="POST">
                    @csrf
                    <div class="color-customizaion">
                        <label for="site_title">Site Title</label>
                        <input type="text" name="site_title" id="site_title" value="{{App\Models\Setting::getValue('site_title') ?? 'SHOP'}}" required>
                        <label for="background_color">Background Color</label>
                        <input type="color" name="background_color" id="background_color" value="{{App\Models\Setting::getValue('background_color') ?? '#DBDBDB'}}" class="color-box">
                        <label for="primary_color">Primary Color</label>
                        <input type="color" name="primary_color" id="primary_color" value="{{App\Models\Setting::getValue('primary_color') ?? '#fff'}}" class="color-box">
                        <label for="secondary_color">Secondary Color</label>
                        <input type="color" name="secondary_color" id="secondary_color" value="{{App\Models\Setting::getValue('secondary_color') ?? '#333'}}" class="color-box">
                        <label for="button_color">Button Color</label>
                        <input type="color" name="button_color" id="button_color" value="{{App\Models\Setting::getValue('button_color') ?? '#3A59D1'}}" class="color-box">
                    </div>
                    <div class="flex gap-3">
                        <input type="hidden" name="does_expiry" value="0">
                        <input type="checkbox" name="does_expiry" id="has_expiry" value="1" {{App\Models\Setting::getValue('does_expiry') ? 'checked' : ''}} class="w-5">
                        <label for="has_expiry">Does your products have expiry dates</label>
                    </div>

                    <div class="flex gap-3">
                        <input type="hidden" name="does_country" value="0">
                        <input type="checkbox" name="does_country" id="has_conutry" value="1" {{App\Models\Setting::getValue('does_country') ? 'checked' : ''}} class="w-5">
                        <label for="has_conutry">Does your products have different countries</label>
                    </div>
                    <button type="submit">Update</button>
                </form>
            </div>
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button type="submit" class="w-max h-max py-3 px-5 rounded-lg text-lg text-red-700 font-semibold">Logout</button>
            </form>
        </div>
    </div>
@endsection
