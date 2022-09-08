@props(['script' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Devices</title>

    {{-- Meta data --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('build/css/style.css')}}">

    {{-- Script --}}
    <script src="{{asset('build/js/app.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        var _dir = "{{url('')}}";
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link{{(Request::url() == url('/') ? ' active' : '')}}" aria-current="page" href="{{url('/')}}">Devices</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {!! auth()->user()->name !!}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <form method="POST" action="{{route('login.destroy')}}">
                                @csrf
                                <li>
                                    <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                </li>
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link{{(Request::url() == url('/login') ? ' active' : '')}}" aria-current="page" href="{{url('/login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{(Request::url() == url('/register') ? ' active' : '')}}" aria-current="page" href="{{url('/register')}}">Register</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link{{(Request::url() == url('/contact') ? ' active' : '')}}" aria-current="page" href="{{url('/contact')}}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container pt-4">
    {{ $slot }}
</main>
<footer class="mt-4 bg-light">
    <div class="container">
        <div class="py-3">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="{{url('/')}}" class="nav-link px-2 text-muted">Devices</a></li>
                @auth()
                    <form method="POST" action="{{route('login.destroy')}}">
                        @csrf
                        <li class="nav-item">
                            <button type="submit" class="btn btn-link nav-link px-2 text-muted">Logout</button>
                        </li>
                    </form>
                @else
                    <li class="nav-item"><a href="{{url('/login')}}" class="nav-link px-2 text-muted">Login</a></li>
                    <li class="nav-item"><a href="{{url('/register')}}" class="nav-link px-2 text-muted">Register</a></li>
                @endauth
                <li class="nav-item"><a href="{{url('/contact')}}" class="nav-link px-2 text-muted">Contact</a></li>
            </ul>
            <p class="text-center text-muted">© {{date('Y')}} Company</p>
        </div>
    </div>
</footer>
<x-message/>
{{ $script }}
</body>
</html>
