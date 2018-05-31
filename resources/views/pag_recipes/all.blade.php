@extends('master')
@section('title','Tutte le ricette - Il mio frigo')
@section('content')

    <div id="body">
        <form class="main-form" action="" method="post">
            <input id="ricerca" type="text" class="form-control" placeholder="Ricerca..."/>
            <button id="search" class="btn btn-warning" function="cerca_all()">
                <a class="text-muted" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
                </a>
            </button>
            <br/>
            <input id="" type="text" class="form-control filter" placeholder="Tipo"/>
            <input id="" type="text" class="form-control filter" placeholder="Tempo cottura"/>
            <input id="" type="text" class="form-control filter" placeholder="Tempo preparazione"/>
            <input id="" type="text" class="form-control filter" placeholder="Difficolta"/>
            <button id="cerca_con_filtri" class="btn btn-warning filter" function="cerca_by_filters()">Cerca</button>
        </form>
        <div id="ricette_db">
            <div class="container">
                <?php
                    try{
                        $x = 0;
                        foreach ($ricette as $singola_ricetta){
                            if($x == 3){
                                $x = 0;
                                echo '</div>';
                            }
                            if($x == 0)
                                echo '<div class="row">';
                            echo '<div class="col-sm">';
    //                        echo "<div class='single_recipe'>";
                            echo "<h1><a href=".$singola_ricetta['id'].">";
                            echo $singola_ricetta['name_recipe'];
                            echo "</a></h1>";
                            echo "<img src='".$singola_ricetta['recipe_img'] ."' alt='".$singola_ricetta['name_recipe']."'>";
                            echo "<li> difficolta: ".$singola_ricetta['difficulty']."</li>";
                            echo "<li> dosi: ".$singola_ricetta['doses_per_person']."</li>";
                            echo "<li> tempo di cottura: ".$singola_ricetta['cooking_time'] ."</li>";
                            echo "<li> tempo di preparazione:".$singola_ricetta['preparation_time']."</li>";
                            echo "</div>";
                            $x++;
                        }
                        echo '<form class="main-form" action="/all" method="post">';
                        echo csrf_field();
                        echo '<button type="submit" class="btn btn-warning" id="button_all">Carica altri risultati</button>';
                        echo '</form>';
                    }catch (Exception $ex){

                    }
                ?>
            </div>
        </div>
    </div>
@endsection