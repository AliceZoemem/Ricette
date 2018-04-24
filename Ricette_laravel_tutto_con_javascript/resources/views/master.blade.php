<!DOCTYPE html>
<html >


    <head>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/Ricette_stile.css') }}" />
        <script src="{{ asset('/js/Ricette_js.js') }}"></script>
        <title>@yield('title')</title>

    </head>


    <body onload="start()">
        @include('pag_recipes.rightmenu')
        @include('pag_recipes.header')

        <div class="container">
            @yield('content')

        </div>
    </body>
    <footer>

    </footer>
</html>
