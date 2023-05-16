<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: #f1fbff ;
        }
     .cont {
        margin-top: 40px ;
     }
     .card {

        width : 640px ;
        margin: auto ;
        border: none ;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;

     }
     .card-header {
        text-align: center ;
        font-size: 24px ;
        font-weight: 700 ;
        text-transform: uppercase ;
        background :white ;

     }

    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger mr-5">
                                <i class="fa fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            @yield('content')
        </main>
    </div>

</body>

</html>
