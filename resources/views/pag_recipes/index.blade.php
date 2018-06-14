@extends('master')

@section('title','Cerca - Tasty&Yummy')

@section('content')
    <style>
        /*#main{*/
            /*background-color: #f1f2f2;*/
            /*background-position: 0 0;*/
            /*background-repeat: no-repeat;*/
            /*background-size: cover;*/
            /*height: 25.75rem;*/
            /*line-height: 1;*/
            /*margin: 0 0 1rem;*/
            /*position: relative;*/
            /*text-align: center;*/
        /*}*/

    </style>
    <form class="main-form" action="/add_research" method="post">
        {{ csrf_field() }}
        {{--<input id="token_invisible" type="hidden" value="{{ csrf_token() }}">--}}
        <input type="text" class="lower form-control" id="ingredienti" name="ingredienti" placeholder="Aggiungi un ingrediente..."/>
        <button type="submit" class="btn btn-warning" onclick="aggiungi()" id="button_add">AGGIUNGI</button>
    </form>

    <div id="inserisci_ingredienti" >
        <ul id="lista_ing" style="list-style-type: none;" >
            {{ csrf_field() }}
            <?php
                try{
                    echo $lista_ricerca;
                }catch(Exception $ex){

                }
            ?>
        </ul>
        <form class="main-form" action="/give_ingredient" method="post">
            {{ csrf_field() }}
            <?php
                try{
                    echo $attiva_ricerca;
                }catch(Exception $ex){

                }
            ?>
            <p id="avvia" style="font-size:24px">Avvia la ricerca:</p>
        </form>
    </div>

    <section class="corpo_sugg">
        <div id="ricette_db">
            <div class="container">
                <?php
                try{
                    $x = 0;
                    foreach ($ricette as $key => $singola_ricetta){
                        if($x == 3){
                            $x = 0;
                            echo '</div>';
                        }
                        if($x == 0){
                            if(count($ricette) % 3  == 1 && $key == count($ricette)-1)
                                echo '<div class="row last">';
                            elseif(count($ricette) % 3  == 2 && $key == count($ricette)-2)
                                echo '<div class="row last">';
                            else
                                echo '<div class="row">';
                        }

                        echo '<div class="col-sm">';
                        echo '<a href="/ricetta/'.$singola_ricetta['id'].'">';
                        //                        echo "<div class='single_recipe'>";
                        echo "<h1>";
                        echo $singola_ricetta['name_recipe'];
                        echo "</h1>";
                        echo "<img src='".$singola_ricetta['recipe_img'] ."' alt='".$singola_ricetta['name_recipe']."' class='single_recipe_img'>";
                        echo "<li> difficolta: ".$singola_ricetta['difficulty']."</li>";
                        echo "<li> dosi: ".$singola_ricetta['doses_per_person']."</li>";
                        echo "<li> tempo di cottura: ".$singola_ricetta['cooking_time'] ."</li>";
                        echo "<li> tempo di preparazione:".$singola_ricetta['preparation_time']."</li>";
                        echo "</a>";
                        echo "</div>";

                        $x++;
                    }
                    echo '<form class="main-form" action="/all" method="get">';
                    echo csrf_field();
                    echo '<button type="submit" class="btn btn-warning" id="button_all">Carica altri risultati</button>';
                    echo '</form>';
                }catch (Exception $ex){

                }
                ?>
            </div>
        </div>
    </section>

<script>
    <?php
        try{
            echo $script;
        }catch(Exception $ex){

        }
    ?>
    <?php
        try{
            $str = 'var globalIngredients=[';
            foreach($ingredientifromdb as $num=> $ingrediente){
                if($num != 0){
                    $str .= ', "';
                    $str.= $ingrediente->name .'"';
                }else
                    $str.= '"' .$ingrediente->name .'"';
            }
            $str.=']; ';
            $str.= '$( "#ingredienti" ).autocomplete({
                  source: globalIngredients
                })';
            echo $str;
        }catch(Exception $ex){

        }
    ?>
</script>
@endsection
