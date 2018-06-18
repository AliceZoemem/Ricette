@extends('master')
@section('title','Profilo - Tasty&Yummy')
@section('content')

    <br>
    <br>
    <h1 class="orange">RICETTARIO DI <?php echo $nome ?></h1>
    <br>
    <div class="container">
    <?php
        try{
            $x = 0;
            foreach ($lista_preferiti as $key => $preferiti){
                if($x == 3){
                    $x = 0;
                    echo '</div>';
                }
                if($x == 0){
                    if(count($lista_preferiti) % 3  == 1 && $key == count($lista_preferiti)-1)
                        echo '<div class="row last">';
                    elseif(count($lista_preferiti) % 3  == 2 && $key == count($lista_preferiti)-2)
                        echo '<div class="row last">';
                    else
                        echo '<div class="row">';
                }

                echo '<div class="col-sm">';
                echo '<a href="/ricetta/'.$preferiti->id.'">';
                echo "<h1>";
                echo $preferiti->name_recipe;
                echo "</h1>";
                echo "<img src='".$preferiti->recipe_img."' alt='".$preferiti->name_recipe."' class='single_recipe_img'>";
                echo "<li> difficolta: ".$preferiti->difficulty."</li>";
                echo "<li> dosi: ".$preferiti->doses_per_person."</li>";
                echo "<li> tempo di cottura: ".$preferiti->cooking_time."</li>";
                echo "<li> tempo di preparazione:".$preferiti->preparation_time."</li>";
                echo "</a>";
                echo "</div>";

                $x++;
            }
        }catch(Exception $ex){

        }
    ?>
    </div>

    <script>
        <?php
        try{
            echo $script;
        }catch(Exception $ex){
        }
        ?>
    </script>
@endsection
