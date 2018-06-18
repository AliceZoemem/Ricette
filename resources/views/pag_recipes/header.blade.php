<nav id="header" class="navbar navbar-expand-lg navbar-light container circleBehind">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item small-col"><img src="/img/logo2.png"></li>
            <li class="nav-item">
                <a href="/">Homepage</a>
            </li>
            <li class="nav-item">
                <a href="/cerca">Cerca Ricette</a>
            </li>
            <li class="nav-item">
                <a href="/all">Tutte le ricette</a>
            </li>
            <li class="nav-item">
                <a href="/login">Login</a>
            </li>
            <li class="nav-item">
                <a href="/signup">Registrati</a>
            </li>
        </ul>
    </div>
</nav>

<nav id="headerloggedpeople" class="hidden navbar navbar-expand-lg navbar-light container circleBehind">

    {{--<img src="/img/user6.png"  class="navbar-toggler utente" data-toggle="collapse" data-target="#profilo" aria-controls="profilo" aria-expanded="false" aria-label="Profile">--}}
    <a href="/profilo" class="user_hidden hidden a_user" >
        <img src="/img/user6.png" class="user_hidden navbar-toggler utente hidden">
    </a>
    {{--<a href="/profilo" id="profilo" class="left" ></a>--}}
    <a href="/profilo" id="profilo" class="left" ></a>
    <button class="navbar-toggler menu" type="button" data-toggle="collapse" data-target="#navbarauthSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarauthSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item small-col"><img src="/img/logo2.png"></li>
            <li class="nav-item">
                <a href="/">Homepage</a>
            </li>
            <li class="nav-item">
                <a href="/cerca">Cerca Ricette</a>
            </li>
            <li class="nav-item">
                <a href="/all">Tutte le ricette</a>
            </li>
            <li class="nav-item">
                <a href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

