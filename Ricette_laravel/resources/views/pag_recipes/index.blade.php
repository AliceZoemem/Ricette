@extends('master')

@section('title','Cerca Ricette - Il mio frigo')

@section('content')

    <style>
        #ingrediente{
            height: 30px;
            width: 300px;
        }
    </style>

    <script>
        function inputFocus(i){
            if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
        }
        function inputBlur(i){
            if(i.value==""){ i.value=i.defaultValue; i.style.color="#888"; }
        }

    </script>

    <section class="corpo">
        <div class="aggiungi" >
            {{--<label for="ingrediente">Ingrediente:</label>--}}
            <input type="text" value="Aggiungi un ingrediente..." name="ing" title="Ingrediente" style="color:#888;" id="ingrediente"
                    onfocus="inputFocus(this)" onblur="inputBlur(this)" />
            <input id="token_invisible" type="hidden" value="{{ csrf_token() }}">
            <button type="add" id="button_add" style="font-size: 17px" onclick="aggiungi()">ADD</button>
        </div>

        <div id="inserisci_ingredienti" >
            <ul id="lista_ing" style="list-style-type: none;" >
            </ul>
            <p id="avvia" style="font-size:24px">Avvia la ricerca:</p>
        </div>
    </section>





    <section class="corpo_sugg">
        {{--suggerimenti--}}
    </section>

<script type="text/javascript">
    var globalIngredients=<?php
        $str = '[';
        foreach($ingredientifromdb as $ingrediente){
            $str.= '"'.$ingrediente->name.'", ';
        }
        $str.=']';
        echo $str;
    ?>;
</script>
@endsection
