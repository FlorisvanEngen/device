<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Devices</title>

    {{-- Meta data --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{url('/css/app.css')}}" rel="stylesheet">

    {{-- Script --}}
    <script src="{{url('/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        var _dir = "{{url('')}}";
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('')}}">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{url('/devices')}}">Devices</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if(auth()->user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{url('/devices/create')}}">Create a Device</a></li>
                            @endif
                            <form method="POST" action="{{url('/logout')}}">
                                @csrf
                                <li>
                                    <button type="submit" class="btn btn-link dropdown-item">Log out</button>
                                </li>
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{url('/login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{url('/register')}}">Register</a>
                    </li>
                @endauth
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
                <li class="nav-item"><a href="{{url('')}}" class="nav-link px-2 text-muted">Home</a></li>
                @auth()
                    <li class="nav-item"><a href="{{url('/devices')}}" class="nav-link px-2 text-muted">Devices</a></li>
                    <li class="nav-item"><a href="{{url('/logout')}}" class="nav-link px-2 text-muted">Logout</a></li>
                @else
                    <li class="nav-item"><a href="{{url('/login')}}" class="nav-link px-2 text-muted">Login</a></li>
                    <li class="nav-item"><a href="{{url('/login')}}" class="nav-link px-2 text-muted">Register</a></li>
                @endauth
            </ul>
            <p class="text-center text-muted">© 2021 Company, Inc</p>
        </div>
    </div>
</footer>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible mb-0 fade show fixed-bottom" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
</body>
</html>
