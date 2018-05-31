<?php
//    use Illuminate\Support\Facades\Cookie;
//    $val = Cookie::get('cookie_user');
//    try{
//        $script = "$('headerloggedpeople').show();";
//        $script .= "$('header').hide();";
//    }catch(Exception $ex){
//
//    }
?>
<!--id="header" navbar-expand-lg navbar-light container circleBehind -->
<nav id="header" class="navbar navbar-expand-lg navbar-light container circleBehind">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/">Homepage</a>
            </li>
            <li class="nav-item">
                <a href="index">Cerca Ricette</a>
            </li>
            <li class="nav-item">
                <a href="all">Tutte le ricette</a>
            </li>
            <li class="nav-item">
                <a href="login">Login</a>
            </li>
            <li class="nav-item">
                <a href="signup">Registrati</a>
            </li>
        </ul>
    </div>
</nav>


{{--navbar-expand-lg navbar-light container--}}
<nav  id="headerloggedpeople" class="hidden navbar-expand-lg navbar-light container circleBehind ">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <p>Profilo</p>
        <a href="profilo" id="profilo" class="left" >A</a>
        <a href="/">Homepage</a>
        <a href="index">Cerca Ricette</a>
        <a href="all">Tutte le ricette</a>
        <a href="logout">Logout</a>
    </div>
</nav>


{{--<nav class="navbar navbar-expand-lg navbar-light bg-light">--}}
    {{--<a class="navbar-brand" href="#">Navbar</a>--}}
    {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
        {{--<span class="navbar-toggler-icon"></span>--}}
    {{--</button>--}}

    {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
        {{--<ul class="navbar-nav mr-auto">--}}
            {{--<li class="nav-item active">--}}
                {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="#">Link</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                    {{--Dropdown--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                    {{--<a class="dropdown-item" href="#">Action</a>--}}
                    {{--<a class="dropdown-item" href="#">Another action</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link disabled" href="#">Disabled</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
        {{--<form class="form-inline my-2 my-lg-0">--}}
            {{--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">--}}
            {{--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>--}}
        {{--</form>--}}
    {{--</div>--}}
{{--</nav>--}}