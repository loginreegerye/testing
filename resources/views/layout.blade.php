<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>L!BR | @yield('page_title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ URL::to('/') }}">L!BR</a>
                </div>
                <div>
                @if (Auth::guest())
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ URL::to('auth/login') }}">SIGN IN</a></li>
                        <li><a href="{{ URL::to('auth/register') }}">SIGN UP</a><li>
                    </ul>
                @endif
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('/users') }}">ALL USERS</a></li>
                        <li><a href="{{ URL::to('/books') }}">ALL BOOKS</a></li>
                    </ul>
                    @endif
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user()->role === 'admin')
                        <!--<li><a href="{{ URL::to('/') }}">HOME</a></li>-->
                        <li><a href="{{ URL::to('/user/create') }}">CREATE USER</a></li>
                        <li><a href="{{ URL::to('/book/create') }}">CREATE BOOK</a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{strtoupper(Auth::user()->role.': '.Auth::user()->first_name.' '.Auth::user()->last_name)}}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::to('/user/'.Auth::user()->id) }}">PROFILE</a></li>
                                <li><a href="{{ URL::to('/auth/logout') }}">LOGOUT</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
                </div>
            </div>
        </nav>
        <hr>
        <div class="content">
            @yield('content')
        </div>
        <hr>
        <footer class="footer text-center">
            <p>L!BR V.0.5 BETA</p>
            <p>ALL RIGHTS RESERVED &amp; COPYRIGHT &copy; 2015. CREATED BY _CHERNIUK</p>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
