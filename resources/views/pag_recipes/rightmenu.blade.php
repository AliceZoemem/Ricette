{{--@extends('master')--}}
{{--@section('title','Tutte le ricette - Tasty&Yummy')--}}
{{--@section('rightmenu')--}}
<nav id="rightmenu" class="rightm navbar navbar-expand-lg">
    <button id="btn_cake" class="navbar-toggler right-menu" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="navbar right">
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        {{--@inject('rightmenu', 'App\Http\Controllers\Home')--}}
        {{--@if( empty($ricette_random))--}}
        {{--{{ $rightmenu->getrandomrecipes() }}--}}
        {{--@endif--}}

        <ul id="menu" class="navbar-nav">
            <?php
            try{
                $script = '';
                foreach ($ricette_random as $ricetta){
                    $script .= '<li class="nav-item">aaaa';
//                        echo '<a href="/singlerecipe/'.$ricetta->id.'">'.$ricetta->name_recipe;
//                        echo '<img class="radom_recipe" src="'.$ricetta->recipe_img.'">';
//                        echo '</a>';
                    $script .= '</li>';

                }
                return view('master', ['rightmenu' => $script]);
            }catch(Exception $ex){
            }
            ?>
        </ul>
    </div>
</nav>
{{--@endsection--}}
{{--<li class="nav-item">--}}
{{--<a href="/singlerecipe/15"><u>la pizza senza glutine</u>--}}
{{--<img class="radom_recipe" src="http://www.giallozafferano.it/images/ricette/16/1655/foto_hd/hd650x433_wm.jpg">--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a href="/singlerecipe/117"><u>i samosa di tonno</u>--}}
{{--<img class="radom_recipe" src="http://www.giallozafferano.it/images/ricette/178/17838/foto_hd/hd650x433_wm.jpg">--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a href="/singlerecipe/104"><u>lo strudel con ricotta e spinaci</u>--}}
{{--<img class="radom_recipe" src="http://www.giallozafferano.it/images/ricette/2/268/foto_hd/hd650x433_wm.jpg">--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a href="/singlerecipe/104"><u>lo strudel con ricotta e spinaci</u>--}}
{{--<img class="radom_recipe" src="http://www.giallozafferano.it/images/ricette/2/268/foto_hd/hd650x433_wm.jpg">--}}
{{--</a>--}}
{{--</li>--}}
{{--<li class="nav-item">--}}
{{--<a href="/singlerecipe/56"><u>la zuppa di noodles</u>--}}
{{--<img class="radom_recipe" src="http://www.giallozafferano.it/images/ricette/36/3603/foto_hd/hd650x433_wm.jpg">--}}
{{--</a>--}}
{{--</li>--}}