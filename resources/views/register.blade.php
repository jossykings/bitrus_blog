@extends('layouts.app')
@section('section')
    <div class="contact">
        <div style="margin-top: 40px;  color: #eebc1d;">
            <h1>
                <center>
                    REGISTER
                </center>
            </h1>
        </div>
        <form method="POST" action="{{ route('userstore') }}">
            @csrf
            <div class="contact-container">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="@error('name') error @enderror">
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="@error('username') error @enderror">
                @error('username')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="@error('email') error @enderror">
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="@error('password') error @enderror">
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="@error('password_confirmation') error @enderror">
                @error('password_confirmation')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <div>
                    If you have an account already, click <a href="{{ route('login') }}">here</a> to login
                </div>
                <button class="btn2" type="submit" style="margin-top: 10px;">Submit</button>
            </div>
        </form>
    @endsection
