<!DOCTYPE html>
<html >
    <head>
        <style>
            @font-face{
                font-family: Cookie;
                src: url('{{ public_path('fonts/Cookie/Cookie-Regular.ttf') }}');
            }
            @font-face{
                font-family: IndieFlower;
                src: url('{{ public_path('fonts/Indie_Flower/IndieFlower.ttf') }}');
            }
            @font-face {
                font-family: Lobster;
                src: url('{{ public_path('fonts/Lobster/Lobster-Regular.ttf')}}');
            }
            @font-face {
                font-family: Oswald;
                src: url('{{ public_path('fonts/Oswald/Oswald-Bold.ttf')}}'),
                url('{{ public_path('fonts/Oswald/Oswald-Regular.ttf')}}'),
                url('{{ public_path('fonts/Oswald/Oswald-ExtraLight.ttf')}}'),
                url('{{ public_path('fonts/Oswald/Oswald-Light.ttf')}}'),
                url('{{ public_path('fonts/Oswald/Oswald-Medium.ttf')}}'),
                url('{{ public_path('fonts/Oswald/Oswald-SemiBold.ttf')}}');
            }
            @font-face {
                font-family: Roboto;
                src: url('{{ public_path('fonts/Roboto/RobotoSlab-Regular.ttf')}}'),
                url('{{ public_path('fonts/Roboto/RobotoSlab-Bold.ttf')}}'),
                url('{{ public_path('fonts/Roboto/RobotoSlab-Light.ttf')}}'),
                url('{{ public_path('fonts/Roboto/RobotoSlab-Thin.ttf')}}');
            }
            @font-face {
                font-family: SunFlower;
                src: url('{{ public_path('fonts/Sunflower/Sunflower-Medium.ttf')}}'),
                url('{{ public_path('fonts/Sunflower/Sunflower-Bold.ttf')}}'),
                url('{{ public_path('fonts/Sunflower/Sunflower-Light.ttf')}}');
            }
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Recipe site">
        <meta name="author" content="Albertin Alice">
        <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        {{--<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>--}}
        <link href='{{ asset('/css/bootstrap.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/bootstrap.min.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/style.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/jquery-ui.css') }}' rel='stylesheet' type='text/css'>
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/Ricette_js.js') }}"></script>
        <script src="{{ asset('/js/jquery-1.12.4.js') }}"></script>
        {{--<link rel="stylesheet" href="/resources/demos/style.css">--}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="icon" type="img/png" href="/img/logo2.png">
        {{--icon title bar--}}
        {{--<link rel="shortcut icon" href="your_image_path_and_name.ico" />--}}
        <title>@yield('title')</title>
    </head>

    <body onload="spinner()" class="gifspinner">
        <div id="topmenu" class="container">
            @include('pag_recipes.header')
        </div>

        <nav id="rightmenu" class="rightm navbar navbar-expand-lg">
            {{--<button id="btn_cake" class="navbar-toggler right-menu" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="navbar right">--}}
            {{--</button>--}}

            {{--<div class="collapse navbar-collapse" id="navbarNav">--}}
            <div class="" id="navbarNav">
                <ul id="menu" class="navbar-nav mr-auto">
                    <?php
                    try{
                        $script = '';
                        foreach ($rightmenu as $ricetta){
                            $script .= '<li class="nav-item">';
                            $script .= '<a href="/ricetta/'.$ricetta->id.'">';
                            $script .= '<p>' .$ricetta->name_recipe. '</p>';
                            $script .= '<img class="radom_recipe" src="'.$ricetta->recipe_img.'">';
                            $script .= '</a>';
                            $script .= '</li>';

                        }
                        echo ($script);
                    }catch(Exception $ex){
                    }
                    ?>
                </ul>
            </div>
        </nav>

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
    <script>

        window.onresize = function() {
            if ($(window).width() < 990) {
                $("#profilo").addClass('collapse');
            } else{
                $('#profilo').removeClass('collapse');
            }
        }
        function spinner(){
            setTimeout(function() {
                $('#gif').hide();
            }, 3000);
        }
        $(document).ready(function() {
            if($(window).width() < 1090)
            {
                $("#profilo").addClass('collapse');
            }else{
                $('#profilo').removeClass('collapse');
            }

        } );

    </script>
    @yield('page-js-script')
</html>




