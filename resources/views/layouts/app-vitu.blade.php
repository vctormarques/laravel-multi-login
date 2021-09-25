<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/ruang-admin.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">

</head>
<body id="page-top">
    <div id="wrapper">
    @guest
    @if (Route::has('register'))
    @endif
    @else
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                    {{ config('app.name') }}
                <div class="sidebar-brand-icon">

                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-home"></i>
                    <span>Home</span></a>
            </li>


            <hr class="sidebar-divider">
            <div class="version" id="version-ruangadmin">v1.0</div>
        </ul>
        @endguest

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item dropdown no-arrow">
                               
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                                <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ Auth::user()->name }}
                                <span class="ml-2 d-none d-lg-inline text-white small"> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    
                                <!-- <a class="dropdown-item" href="index.php?class=M_Perfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                     -->
                                <div class="dropdown-divider"></div>
                                
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __('Sair') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </nav>
               

        <div class="container-fluid" id="container-wrapper">
            @yield('content')
        </div> 


        <script src="https://use.fontawesome.com/4299b7b486.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" ></script>
        <script src="{{ asset('js/ruang-admin.min.js') }}" ></script>
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}" ></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}" ></script>
        <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}" ></script>
    </body>
</html>
