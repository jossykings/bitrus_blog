@extends('layouts.app')
@section('section')
    <div class="contact">
        <div style="margin-top: 40px;  color: #eebc1d;">
            <h1>
                <center>
                    Login
                </center>
            </h1>
        </div>
        <form action='{{ route('userlogin') }}' method="post">
            @csrf
            <div class="contact-container">
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
                <div>
                    If you don't have an account, click <a href="{{ route('register') }}">here</a> to register
                </div>
                <button class="btn2" style="margin-top: 10px;">Submit</button>
            </div>
        </form>
    @endsection
