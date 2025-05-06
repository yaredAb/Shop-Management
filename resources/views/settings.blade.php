@extends('layouts.app')

@section('content')
    <div class="setting-wrapper">
        <h2 class="title">Settings</h2>
        <div class="account-setting">

            {{-- Account setting --}}
            <h3 class="sub-title">Account Setting</h3>
            <form action="" class="account-form">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="user123">
                <p>Change Password</p>
                <input type="password" name="password" id="password">
                <button>Update</button>
            </form>

            {{-- forget password form --}}
            <h3 class="sub-title">Forget Password Q&A</h3>
            <span class="warning-message">You need to set this up in order to change your password when you forget it!</span>

            <form action="">
                <div class="form-inline">
                    <p>Question</p>
                    <input type="text" name="question" id="question">
                </div>

                <div class="form-inline">
                    <p>Answer</p>
                    <input type="text" name="answer" id="answer">
                </div>
                <div class="form-inline">
                    <button type="submit">Set</button>
                </div>
            </form>


            {{-- Telegram notification keys --}}
            <h3 class="sub-title">Telegram keys</h3>
            <form action="" class="account-form">
                <label for="bot_token">Bot Token</label>
                <input type="password" name="bot_token" id="bot_token" value="user123">
                <label for="chat_id">Chat Id</label>
                <input type="text" name="chat_id" id="chat_id">
                <button>Save</button>
            </form>


            {{-- Small functionalities setup --}}
            <h3 class="sub-title">Time Setup and other settings</h3>
            <form action="" class="account-form">
                <label for="dailyHour">Set the time to see "Daily Report" button every day.</label>
                <input type="time" name="dailyHour" id="dailyHour">
                <div class="form-inline">
                    <button type="submit">Set</button>
                </div>
            </form>

        </div>
    </div>
@endsection