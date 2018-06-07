@extends('master')
@section('title','Ricetta - Tasty&Yummy')
@section('content')
    <div class="container">
        <a href="/all"><div id="back" title="back"></div></a>
        <?php
            try{
                $echo =
                    '<div id="single_top"><h1>'.$ricetta->name_recipe.'</h1>'.
                    '<img src="'.$ricetta->recipe_img. '" alt="'.$ricetta->name_recipe.'" class="single_image">'.
                    '<ul class="informazioni">'.
                    '<li> difficolta: '.$ricetta->difficulty.'</li>'.
                    '<li> dosi: '.$ricetta->doses_per_person.'</li>'.
                    '<li> tempo di cottura: '.$ricetta->cooking_time.'</li>'.
                    '<li> tempo di preparazione: '.$ricetta->preparation_time.'</li>'.
                    '</ul>'.
                    '<h1 class="h1-left">INGREDIENTI</h1>'.
                    '<ul class="informazioni">';

                for($i = 0; $i < count($pivot['ingredient']); $i++)
                    $echo .= '<li>'. $pivot['ingredient'][$i] . '  ' . $pivot['amount'][$i].'</li>';

                $echo .=
                    '</ul>'.
                    '</div><div id="single_recipe"><h3> Preparazione: </h3>'.
                    '<p>'.$ricetta->description.'</p></div>'.
                    ' </br> </br>';
                echo $echo;
                ;

            }catch (Exception $ex){

            }
        ?>
    </div>
    <script>
        <?php
            try{
                echo $script;
            }catch(Exception $ex){}
        ?>
    </script>
@endsection