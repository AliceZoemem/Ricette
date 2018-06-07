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
        <input type="text" class="lower form-control" id="ingredienti" name="ingredient" placeholder="Aggiungi un ingrediente..."/>
        <button type="submit" class="btn btn-warning" id="button_add">AGGIUNGI</button>
    </form>

    {{--<section class="corpo" id="main">--}}
        {{--<div class="aggiungi form-group">--}}
            {{--<input type="text" class="form-control" id="ingredienti" value="Aggiungi un ingrediente..." onfocus="inputFocus(this)" onblur="inputBlur(this)">--}}

            {{--<input type="text" id="ingredienti" value="Aggiungi un ingrediente..." name="ing" title="Ingrediente" style="color:#888;"--}}
                    {{--onfocus="inputFocus(this)" onblur="inputBlur(this)" />--}}

            {{--<button type="submit" class="btn btn-primary" id="button_add" style="font-size: 17px" onclick="aggiungi()">AGGIUNGI</button>--}}
        {{--</div>--}}

    <div id="inserisci_ingredienti" >
        <ul id="lista_ing" style="list-style-type: none;" >
        </ul>
        <p id="avvia" style="font-size:24px">Avvia la ricerca:</p>
    </div>

    <section class="corpo_sugg">
        {{--suggerimenti--}}
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
