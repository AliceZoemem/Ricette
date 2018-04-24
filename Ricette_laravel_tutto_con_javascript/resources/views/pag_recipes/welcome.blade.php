@extends('master')

@section('title','Cerca Ricette - Il mio frigo')

@section('content')


    <div class="aggiungi">
        <label for="ingrediente">Ingrediente:</label>
        <input type="text" name="ing" id="ingrediente" style="height: 30px; width: 300px;">
        <input id="invisibile" type="hidden" value="{{ csrf_token() }}">
        <button type="add" id="button_add" style="font-size: 17px" onclick="aggiungi()">ADD</button>
    </div>



    <div id="inserisci_ingredienti" >
        <ul id="lista_ing" style="list-style-type: none;" >
        </ul>
        <p id="avvia" style="font-size:24px">Avvia la ricerca:</p>
    </div>

<script type="text/javascript">
        var globalIngredients=<?php
            $str = '[';
            foreach($ingredientifromdb as $ingrediente){
                //controlla se ingrediente->name e un tipo di pasta
                $str.= '"'.$ingrediente->name.'", ';
            }
            $str.=']';
            echo $str;
        ?>;
</script>
@endsection
