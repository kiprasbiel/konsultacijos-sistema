<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('inc.header')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
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
                        @auth
                        <li class="nav-item">
                            <a id="consultations" class="nav-link" href="/konsultacijos" role="button">
                                Konsultacijos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="clients" class="nav-link" href="/klientai" role="button">
                                Klientai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="payments" class="nav-link" href="/apmokejimai" role="button">
                                Apmokejimai
                            </a>
                        </li>
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="/vartotojai" class="dropdown-item">
                                        Vartotojai
                                    </a>
                                    <a href="/settings" class="dropdown-item">
                                        Nustatymai
                                    </a>
                                    <a href="/conf-month-gen" class="dropdown-item">
                                        Eksportavimas
                                    </a>
                                    <a href="/import" class="dropdown-item">
                                        Importavimas
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="container-fluid container-aw px-5">
            @include('inc.messages')
            @yield('content')
        </main>
    </div>
    @include('inc.footer')
</body>
</html>
