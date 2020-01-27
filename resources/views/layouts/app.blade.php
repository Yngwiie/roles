<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Roles y Permisos', 'Roles y Permisos') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/df11a4c4b4.js" crossorigin="anonymous"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/load.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">


</head>
<body >   
    <div id="app" >
    @include('mensajes-flash')   
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container" style="position: relative;">
                <a class="navbar-brand animated "href="{{ url('/home') }}">
                    {{ config('Roles y Permisos', 'Roles y Permisos') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- lado izquierdo de la barra de navegación -->
                    <ul class="navbar-nav mr-auto">
                        <!-- -->
                        @can('roles.index')
                            <li class="nav-item " >   
                                <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                            </li>
                        @endcan
                        @can('users.index')
                            <li class="nav-item dropdown ">   
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuarios</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Usuarios Verificados</a>
                                    <a class="dropdown-item" href="{{ route('users.indexNoVerificados') }}">Usuarios No verificados</a>
                                    <a class="dropdown-item" href="{{ route('users.sinrol') }}">Usuarios sin rol</a>
                                </div>
                            </li>
                        @endcan
                        @can('users.auditoria')
                            <li class="nav-item dropdown ">   
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Auditoria</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.log') }}">Auditoria Inicios de sesión</a>
                                    <a class="dropdown-item" href="{{ route('users.logall') }}">Auditoria Total</a>
                                </div>
                            </li>
                        @endcan
                        

                    </ul>

                    <!-- Lado derecho de la barra de navegación -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Links de autenticación -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Inicio Sesión') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('user.editardatospersonales')
                                        <a class="dropdown-item" href="{{route('users.edicionPersonal',auth()->user()->id)}}">
                                            {{ __('Modificar mis Datos') }}
                                        </a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 clearfix">
            @yield('content')
        </main>
    </div>
</body>

</html>
