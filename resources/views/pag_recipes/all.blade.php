@extends('master')
@section('title','Tutte le ricette - Tasty&Yummy')
@section('content')

    <div id="body">
        <form class="main-form" action="/cerca_ricetta" method="post">
            <input id="ricerca" type="text" name="ricerca" class="lower form-control" placeholder="Ricerca..."/>
            <button id="search" class="btn btn-warning">
                <a class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
                </a>
            </button>
            {{ csrf_field() }}
        </form>
        <form class="main-form form-width filter" action="/filter" method="post">
            <input id="tipo" type="text" name="tipo" class="lower form-control filter" placeholder="Tipo"/>
            <input id="tempo_cottura" type="text" name="tempo_cottura" class="lower form-control filter" placeholder="Tempo cottura"/>
            <input id="tempo_preparazione" type="text" name="tempo_preparazione" class="lower form-control filter" placeholder="Tempo preparazione"/>
            <input id="dosi_persone" type="text" name="dosi_persone" class="lower form-control filter" placeholder="Dosi"/>
            {{--<input id="difficolta" type="text" name="difficolta" class="form-control filter" placeholder="Difficolta"/>--}}
            <select id="difficolta" class="form-control filter" name="difficolta">
            </select>
            <button id="cerca_con_filtri" class="btn btn-warning filter">Cerca</button>
            {{ csrf_field() }}
        </form>
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
                            echo '<a href=ricetta/'.$singola_ricetta['id'].'>';
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
    </div>
    <script>
        <?php
            try{
                echo $script;
            }
            catch(Exception $ex){

            }
        ?>
        <?php

            $nome = 'var FiltroNomi=[';
            foreach($filtri['names'] as $num=>$name){
                if($num != 0){
                    $nome .= ', "';
                    $nome.= $name['name_recipe'] .'"';
                }else
                    $nome.= '"' .$name['name_recipe'] .'"';
            }
            $nome.=']; ';

            $tipo = 'var FiltroTipo=[';
            foreach($filtri['types'] as $num=>$name){
                if($num != 0){
                    $tipo .= ', "';
                    $tipo.= $name['category'] .'"';
                }else
                    $tipo.= '"' .$name['category'] .'"';
            }
            $tipo.=']; ';

            $dose = 'var FiltroDosi=[';
            foreach($filtri['doses'] as $num=>$name){
                if($num != 0){
                    $dose .= ', "';
                    $dose.= $name['doses_per_person'] .'"';
                }else
                    $dose.= '"' .$name['doses_per_person'] .'"';
            }
            $dose.=']; ';

            $diff = '<option value="">nessuna</option>';
            foreach($filtri['difficulties'] as $name){
                if($name['difficulty'] != "-")
                    $diff .= '<option value="'.$name['difficulty'].'">'.$name['difficulty'].'</option>';
            }
            $cottura = 'var FiltroCooking=[';
            foreach($filtri['cooking_times'] as $num=>$name){
                if($num != 0){
                    $cottura .= ', "';
                    $cottura.= $name['cooking_time'] .'"';
                }else
                    $cottura.= '"' .$name['cooking_time'] .'"';
            }
            $cottura.=']; ';
            $preparazione = 'var FiltroPreparation=[';
            foreach($filtri['preparation_times'] as $num=>$name){
                if($num != 0){
                    $preparazione .= ', "';
                    $preparazione.= $name['preparation_time'] .'"';
                }else
                    $preparazione.= '"' .$name['preparation_time'] .'"';

            }
            $preparazione.=']; ';
            $str = $preparazione .$nome . $tipo .$cottura. $dose . '$( "#tipo" ).autocomplete({source: FiltroTipo});'
                    .' $( "#tempo_cottura" ).autocomplete({source: FiltroCooking});'
                    .' $( "#tempo_preparazione" ).autocomplete({source: FiltroPreparation});'
                    .' $( "#ricerca" ).autocomplete({source: FiltroNomi});'
                    .' $( "#dosi_persone" ).autocomplete({source: FiltroDosi});'
                    ."$('#difficolta').html('".$diff."')";
            echo $str;
        ?>

    </script>
@endsection