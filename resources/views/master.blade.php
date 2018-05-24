<!DOCTYPE html>
<html >
    <head>
        <style>

        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Recipe site">
        <meta name="author" content="Albertin Alice">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/bootstrap.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/bootstrap.min.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/style.css') }}' rel='stylesheet' type='text/css'>
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/Ricette_js.js') }}"></script>
        <title>@yield('title')</title>
    </head>

    <body onload="">

        <div id="topmenu" class="container">
            @include('pag_recipes.header')
        </div>
        @include('pag_recipes.rightmenu')
        <div class="content">
            @yield('content')
        </div>
        <footer class="footer">
            <div onclick="topFunction()" id="scrollup" title="Go to top"></div>
            <div class="container_footer">
                <p class="text-muted">Copyright 2018 by @alicealbertin</p>
            </div>
        </footer>
    </body>
    @yield('page-js-script')
</html>




