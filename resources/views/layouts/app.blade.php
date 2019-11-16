<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mesa de Servicios') }}</title>

    <!-- Styles -->
    <link rel="icon" href="{{ asset('img/logo.PNG') }}">
    <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
    </script>
    <style type="text/css">
        .navbar-default .navbar-nav > .open > a,
        .navbar-default .navbar-nav > .open > a:hover,
        .navbar-default .navbar-nav > .open > a:focus {
            color: #555;
            background-color: #eeeeee7d;
        }

        .nav_color {
            background-image: linear-gradient(to left,
            #ea0f16, #f1222f, #f73245, #fb4159, #fe506c, #fe526c,
            #ff536d, #ff556d, #ff4c5a, #ff4544, #ff412b, #ff4100);
        }

        body {
            background-color: whitesmoke !important;
        }

        .h3_form {
            padding-left: 1px !important;
            margin-right: 50% !important;
            color: white;
            font-size: 18px
        }
    </style>
    @yield('style-id')
    <link rel="stylesheet" href="{{ asset('dist/simplelightbox.min.css') }}">
</head>
<body>
<div id="app">
    @if(Auth::user())
        <nav class="navbar navbar-default navbar-static-top nav_color">
            {{--        <nav class="navbar navbar-pills nav-stacked nav_color">--}}
            <img src="{{ asset('img/logo.PNG') }}"
                 data-toggle="tooltip"
                 data-placement="bottom"
                 title="Mesa de Servicio"
                 alt="LOGO" style="width: 3.5% !important; position: absolute !important;">
            <div class="container">

                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" style="color: white !important; font-weight: bolder !important;"
                       href="{{ Auth::user()->role !== 'admin' ? url('servicios_all') : url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::user()['role'] === 'admin')
                            <li><a style="color: white !important; font-weight: bolder !important;"
                                   href="{{ url('servicios_all')}}">
                                    <i class="fas fa-tasks"></i>&nbsp; Servicios</a></li>
                            <li><a style="color: white !important; font-weight: bolder !important;"
                                   href="{{ url('users_all')}}">
                                    <i class="fas fa-user-circle"></i>&nbsp; Usuarios</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Acceder</a></li>
                            {{--                            <li><a href="{{ url('/register') }}">Registrarse</a></li>--}}
                        @else
                            <li class="dropdown">
                                <a style="color: white !important; font-weight: bolder !important;"
                                   href="#" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    @endif
    <div>
        @if(Session::has('message'))
            <div class="container">
                <div class="row">
                    <div class="alert alert-info">
                        <p style="text-align:center">{{ Session::get('message')}}</p>
                    </div>
                </div>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js')}}"></script>
<script src="{{ asset('js/semantic.min.js')}}"></script>
<script src="{{ asset('js/Chart.min.js')}}"></script>
<script src="{{ asset('dist/simple-lightbox.min.js') }}"></script>
@stack('scripts')
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</body>
</html>
