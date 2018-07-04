@extends('master')

@section('title','Tasty&Yummy')

@section('content')
    <style>
        .char1 {transform: rotate(-75deg);}
        .char2 {transform: rotate(-60deg);}
        .char3 {transform: rotate(-45deg);}
        .char4 {transform: rotate(-30deg);}
        .char5 {transform: rotate(-15deg);}
        .char6 {transform: rotate(0deg);}
        .char7 {transform: rotate(15deg);}
        .char8 {transform: rotate(30deg);}
        .char9 {transform: rotate(45deg);}
        .char10 {transform: rotate(60deg);}
        .char11 {transform: rotate(75deg);}

    </style>
    <br>
    <img id="gif" src="/img/p.gif">
    <section class="corpo_sugg">

        {{--<h1>--}}
            {{--<span class="char1">T</span>--}}
            {{--<span class="char2">a</span>--}}
            {{--<span class="char3">s</span>--}}
            {{--<span class="char4">t</span>--}}
            {{--<span class="char5">y</span>--}}
            {{--<span class="char6">&</span>--}}
            {{--<span class="char7">Y</span>--}}
            {{--<span class="char8">u</span>--}}
            {{--<span class="char9">m</span>--}}
            {{--<span class="char10">m</span>--}}
            {{--<span class="char11">y</span>--}}
        {{--</h1>--}}
        <h1 id="title">Tasty&Yummy</h1>
        <img id="logohome" src="/img/logo2.png">
        <h2 class="subtitle">Choose your meal and enjoy cooking</h2>
    </section>

    <script>
//        $(function() {
//            $("h1").lettering();
//        });
        <?php
            try{
                echo $script;
            }catch(Exception $ex){}
        ?>
    </script>
@endsection
