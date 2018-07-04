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

            .sidenav {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 2;
                top: 0;
                right: 0;
                background-color: rgba(250, 250, 250, 0.8);;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 12%;
            }
            .sidenav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }
            .sidenav a:hover {
                color: #f1f1f1;
            }
            .sidenav .closebtn {
                position: absolute;
                top: 0;
                right: 5%;
                font-size: 36px;
                margin-left: 10%;
            }
            @media screen and (max-height: 450px) {
                .sidenav {padding-top: 3%;}
                .sidenav a {font-size: 18px;}
            }
            @media screen and (max-width: 550px) {
                .sidenav {padding-top: 3%;}
                .sidenav a {font-size: 18px;}
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
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="icon" type="img/png" href="/img/logo2.png">
        <title>@yield('title')</title>
    </head>

    <body onload="spinner()" class="gifspinner">
        <div id="menu-fixed">
            <div id="topmenu" class="container">
                @include('pag_recipes.header')
            </div>
           {{--QUA INIZIA--}}
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="" id="">
                    <ul id="" class="">
                        <?php
                        try{
                            $script = '';
                            foreach ($rightmenu as $ricetta){
                                $script .= '<li class="nav-item right-item">';
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
            </div>

            {{--<button id="btn_cake" class="navbar-toggler right-menu" type="button" onclick="rightmenu()">--}}
            <button id="btn_cake" class="navbar-toggler right-menu" type="button" onclick="openNav()">
            </button>
            <nav id="rightmenu" class="rightm navbar navbar-expand-lg old">
                <div class="" id="navbarNav">
                    <ul id="menu" class="navbar-nav mr-auto">
                        <?php
                        try{
                            $script = '';
                            foreach ($rightmenu as $ricetta){
                                $script .= '<li class="nav-item ">';
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
        </div>

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
        function openNav() {
            document.getElementById("mySidenav").style.width = "40%";
            if ($(window).width() < 370) {
                document.getElementById("mySidenav").style.width = "60%";
            }
            if ($(window).width() > 780) {
                document.getElementById("mySidenav").style.width = "0%";
            }
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0%";
        }
        window.onresize = function() {
            if ($(window).width() < 990) {
                if ($(window).width() < 780) {
                    $("#rightmenu").hide();
                    $("#rightmenu").addClass('rightmenu_colonna');
                    $("#menu").addClass('ul_colonna');
//
                }else{
                    $("#rightmenu").show();
                    $("#rightmenu").removeClass('rightmenu_colonna');
                    $("#menu").removeClass('ul_colonna');
                    $(".user_hidden").removeClass('hidden');
                    $("#rightmenu").removeClass('old');
                }
            } else{
                $('#mySidenav').width('0%');
                $("#rightmenu").addClass('old');
                $(".user_hidden").addClass('hidden');
            }
        }
        function rightmenu(){
            $("#rightmenu").hide();
            $("#rightmenu").addClass('rightmenu_colonna');
            $("#menu").addClass('ul_colonna');
            if(rightmenu_visible == 0){
                $("#rightmenu").show();
                rightmenu_visible = 1;
            }else{
                $("#rightmenu").hide();
                rightmenu_visible = 0;
            }
        }

        function spinner(){
            setTimeout(function() {
                $('#gif').hide();
            }, 3000);
        }

        $(document).ready(function() {
            if($(window).width() < 990)
            {
                if ($(window).width() < 780) {
                    $("#rightmenu").removeClass('old');
                    $("#rightmenu").addClass('rightmenu_colonna');
                    $("#menu").addClass('ul_colonna');
                    $("#rightmenu").hide();
                }else{
                    $("#rightmenu").show();
                    $("#rightmenu").removeClass('rightmenu_colonna');
                    $("#menu").removeClass('ul_colonna');
                    $("#rightmenu").removeClass('old');
                    $(".user_hidden").removeClass('hidden');
                }
            }else{
                $('#mySidenav').width('0%');
                $(".user_hidden").addClass('hidden');
                $("#rightmenu").addClass('old');
            }

        } );



    </script>
    @yield('page-js-script')
</html>




