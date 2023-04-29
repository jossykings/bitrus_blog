<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Work it | Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="nav">
        <div class="nav-container">
            {{-- <div class="logo">
                <a href="/"><img src="{{ asset('images/myloogoo.jpg') }}" alt="logo" /></a>
            </div> --}}
            <div class="navlist">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    @auth
                        @admin
                            <li><a href="{{ route('dashboard') }}" class="btn">Dashboard</a></li>
                        @endadmin
                        @user
                            <li>{{ auth()->user()->username }}</li>
                        @enduser
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn">Logout</button>
                        </form>

                    @endauth
                    @guest
                        <li><a href="{{ route('register') }}" class="btn">Register</a></li>
                        <li><a href="{{ route('login') }}" class="btn">Login</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        @include('partials.errors')
        @yield('section')
    </div>
    <script>
        @yield('script')
    </script>
</body>

</html>
