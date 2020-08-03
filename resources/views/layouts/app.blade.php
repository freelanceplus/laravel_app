<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">


    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet">


    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">
</head>
<body>
    <div id="app">

        @if($user_type == 'buyer')
            <nav class="navbar navbar-expand-md shadow-sm" style="background: #111111">
                <div class="container">
                    <a class="navbar-brand" style="color: white" href="{{ url('/') }}">
                        FreeLaunce Plus
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @if(!session()->has('buyer'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color: white" href="{{ URL::to('buyer/login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color: white" href="{{ URL::to('buyer/signup') }}">{{ __('Register') }}</a>
                                </li>
                            @else
{{--                                <li class="nav-item dropdown">--}}
{{--                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                        {{ session('buyer')->getPerson()->name }} <span class="caret"></span>--}}
{{--                                    </a>--}}

{{--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                        <a class="dropdown-item" href="{{ URL::to('seller/logout') }}">--}}
{{--                                            {{ __('Logout') }}--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        @elseif($user_type == 'seller')
            <nav class="navbar navbar-expand-md navbar-light shadow-sm"  style="background: #111111">
                <div class="container">
                    <a class="navbar-brand" style="color: white" href="{{ url('/') }}">
                        Firelaunce Plus
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @if(!session()->has('seller'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color: white" href="{{ URL::to('seller/login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color: white" href="{{ URL::to('seller/signup') }}">{{ __('Register') }}</a>
                                </li>
                            @else
{{--                                <li class="nav-item dropdown">--}}
{{--                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                        {{ session('seller')->getPerson()->name }} <span class="caret"></span>--}}
{{--                                    </a>--}}

{{--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
{{--                                        <a class="dropdown-item" href="{{ URL::to('seller/logout') }}">--}}
{{--                                            {{ __('Logout') }}--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        @elseif($user_type == 'admin')
            <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background: #111111">

                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <a class="navbar-brand" style="color: white" href="{{ url('/') }}">
                                FreeLauncePlus
                            </a>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->

                                <li class="nav-item">
                                    <a class="nav-link" style="color: white" href="">Admin Login</a>
                                </li>
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ URL::to('seller/login') }}">{{ __('Login') }}</a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ URL::to('seller/signup') }}">{{ __('Register') }}</a>--}}
{{--                                </li>--}}
                        </ul>
                    </div>
                </div>
            </nav>
        @endif


        <main class="py-4">
            @yield('content')
        </main>

    </div>
    <script src={{asset("vendor/jquery-3.2.1.min.js")}}></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src={{asset("vendor/jquery-3.2.1.min.js")}}></script>
    <script src={{asset("vendor/jquery-3.2.1.min.js")}}></script>
    <!-- Vendor JS       -->
    <script src={{asset("vendor/slick/slick.min.js")}}></script>
    <script src={{asset("vendor/wow/wow.min.js")}}></script>
    <script src={{asset("vendor/animsition/animsition.min.js")}}></script>
    <script src={{asset("vendor/bootstrap-progressbar/bootstrap-progressbar.min.js")}}></script>
    <script src={{asset("vendor/counter-up/jquery.waypoints.min.js")}}></script>
    <script src={{asset("vendor/counter-up/jquery.counterup.min.js")}}></script>
    <script src={{asset("vendor/circle-progress/circle-progress.min.js")}}></script>
    <script src={{asset("vendor/perfect-scrollbar/perfect-scrollbar.js")}}></script>
    <script src={{asset("vendor/chartjs/Chart.bundle.min.js")}}></script>
    <script src={{asset("vendor/select2/select2.min.js")}}></script>
    <!-- Main JS-->
    <script src={{asset("js/main.js")}}></script>

    <script>

        $(".skills_tags").select2({
            maximumSelectionLength: 5
        });
    </script>
</body>
</html>
