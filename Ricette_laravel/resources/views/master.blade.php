<!DOCTYPE html>
<html >
    <style>
        @font-face {
            font-family: Myfont;
            src: url(ufonts.com_segoe_script.eot);
        }
        .intro{
            font-size: 400%;
            font-family: "Myfont";
            text-align: center;
            margin-bottom: 2px;
        }
        .container{
            text-align: center;
        }
    </style>
    <head>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ URL::asset('/css/Ricette_stile.css') }}" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="{{ asset('/js/Ricette_js.js') }}"></script>
        <title>@yield('title')</title>
    </head>

    <body onload="start()">

        {{--{{Home::getrandomrecipes()}}--}}
        {{--<script>window.location = "/rightmenu";</script>--}}
        @include('pag_recipes.rightmenu')
        @include('pag_recipes.header')
        <div class="intro"> Il mio frigo</div>
        <div class="container">
            @yield('content')
        </div>
        </br>
        <footer class="footer">
            <div class="container_footer">
                <p class="text-muted">Ricette - project by @alicealbertin</p>
            </div>
        </footer>
    </body>
</html>
<!-- <small>Ricette - project by @alicealbertin</small>-->