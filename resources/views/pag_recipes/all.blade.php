@extends('master')
@section('title','Tutte le ricette - Il mio frigo')
@section('content')
    <style>

    </style>

    <div id="body">
        <form class="main-form" action="" method="post">
            <input id="ricerca" type="text" class="form-control" placeholder="Ricerca..."/>
            <button id="search" class="btn btn-warning" function="cerca_all()">
                <a class="text-muted" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
                </a>
            </button>
        </form>
        <div id="ricette_db">
            <?php
                foreach ($ricette as $singola_ricetta){
                    echo "<h1><a href=".$singola_ricetta['id'].">";
                    echo "<u>".$singola_ricetta['id']->name_recipe."</u>";
                    echo "</a></h1>";
                    echo "<img src='".$singola_ricetta['id']->recipe_img ."' alt='".$singola_ricetta->name_recipe."'>";
                    echo "<li> difficolta: ".$singola_ricetta['id']->difficulty."</li>";
                    echo "<li> dosi: ".$singola_ricetta['id']->doses_per_person."</li>";
                    echo "<li> tempo di cottura: ".$singola_ricetta['id']->cooking_time ."</li>";
                    echo "<li> tempo di preparazione:".$singola_ricetta['id']->preparation_time."</li>";
                    echo "</br></br>";
                }

            ?>
        </div>
    </div>
@endsection