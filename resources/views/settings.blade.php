@extends('layouts.app')

@section('content')
    <div class="setting-wrapper">
        <h2 class="title">Settings</h2>
        <div class="setting-container">
            <div class="setting-main">
                <div class="account-setting">
                    {{-- Account setting --}}
                    <h3 class="sub-title">Account Setting</h3>
                    <form action="{{route('updatePassword')}}" method="POST" class="account-form">
                        @csrf
                        <label for="username">Username</label>
                        <input type="text" id="username" value="{{$user->username}}" disabled>
                        <p>Change Password</p>
                        <input type="password" name="password" id="password" required>
                        <button>Update</button>
                    </form>
                    {{-- forget password form --}}
                    <h3 class="sub-title">Forget Password Q&A</h3>
                    @if (!$user->security_question || !$user->security_answer)
                        <span class="warning-message">You need to set this up in order to change your password when you forget it!</span>
                    @endif
                    <form action="{{route('securityQA')}}" method="POST">
                        @csrf
                        <div class="form-inline">
                            <p>Question</p>
                            <input type="text" name="security_question" id="question" value="{{$user->security_question}}" required>
                        </div>
                        <div class="form-inline">
                            <p>Answer</p>
                            <input type="text" name="security_answer" id="answer" value="{{$user->security_answer}}" required>
                        </div>
                        <div class="form-inline">
                            <button type="submit">Set</button>
                        </div>
                    </form>
                    {{-- Telegram notification keys --}}
                    <h3 class="sub-title">Telegram keys</h3>
                    <form action="{{route('settings.setTelegramToken')}}" class="account-form" method="POST">
                        @csrf
                        <label for="bot_token">Bot Token</label>
                        <input type="password" name="bot_token" id="bot_token" value="{{ \App\Models\Setting::getValue('telegram_bot_token') }}">
                        <label for="chat_id">Chat Id</label>
                        <input type="text" name="chat_id" id="chat_id" value="{{ \App\Models\Setting::getValue('telegram_chat_id') }}">
                        <button type="submit">Save</button>
                    </form>
                    {{-- Small functionalities setup --}}
                    <h3 class="sub-title">Time Setup to recieve daily report at telegram</h3>
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
                <h3 class="sub-title">Site Customization</h3>
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
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection