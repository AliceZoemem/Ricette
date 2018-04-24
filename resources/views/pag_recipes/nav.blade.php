<nav class="navbar navbar-default navbar-fixed-top navbar-absolute navbar-transparent" id="topmenu" style="height: 5%;">
    <div class="container-fluid">

        <div class="navbar-header page-scroll">
            <button type="button" onclick="nav()" style="float: left" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="/">Il mio frigo</a>
            <a class="navbar-brand page-scroll" href="{{ url('/signup') }}"><span class="glyphicon glyphicon-user"></span></a>
            <a class="navbar-brand page-scroll" href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span></a>

        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        {{--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">--}}
            {{--<ul class="nav navbar-nav navbar-left">--}}
                {{--<li class="{{ (Request::is('/') ? 'active' : '') }}">--}}
                    {{--<a href="{{ url('') }}"><i class="fa fa-home"></i> Home</a>--}}
                {{--</li>--}}
                {{--<li class="{{ (Request::is('all') ? 'active' : '') }}">--}}
                    {{--<a href="{{ url('all') }}">Tutte le ricette</a>--}}
                {{--</li>--}}
                {{--<li class="{{ (Request::is('twopeople') ? 'active' : '') }}">--}}
                    {{--<a href="{{ url('twopeople') }}">Ricette per 2</a>--}}
                {{--</li>--}}
                {{--<li class="{{ (Request::is('contact') ? 'active' : '') }}">--}}
                    {{--<a href="{{ url('contact') }}">Contatti</a>--}}
                {{--</li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span>name</span> <i class="icon-user fa"></i> <i class=" icon-down-open-big fa"></i></a>--}}
                    {{--<ul class="dropdown-menu user-menu">--}}
                        {{--<li class="active"><a href="account-home.html"><i class="icon-home"></i> Personal Home </a></li>--}}
                        {{--<li><a href="statements.html"><i class=" icon-money "></i> Payment history </a></li>--}}

                        {{--<li><a href="logout"> <i class="glyphicon glyphicon-off"></i> Signout </a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    </div>
</nav>
