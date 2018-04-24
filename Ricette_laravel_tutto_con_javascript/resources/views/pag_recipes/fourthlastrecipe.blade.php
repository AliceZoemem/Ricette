@extends('master')

@section('title','Last 5 Recipes - Il mio frigo')

@section('content')
    <div id="img_ricette" >

    </div>

    <div id="description" >

    </div>

    <script type="text/javascript">
        $.get( "api/recipes/4", function( data ) {
            var cdiv = $('#description');
            var h1 = $('<h1 />')
                .text(data.recipes[3].name_recipe)
                .appendTo(cdiv);
            var l_diff = $('<li />')
                .text('difficolta: ' + data.recipes[3].difficulty)
                .appendTo(cdiv);
            var l_dosi = $('<li />')
                .text('dosi: ' + data.recipes[3].doses_per_person)
                .appendTo(l_diff);
            var l_tempo_c = $('<li />')
                .text('tempo di cottura: ' + data.recipes[3].cooking_time)
                .appendTo(l_dosi);
            var l_tempo_p = $('<li />')
                .text('tempo di preparazione: ' + data.recipes[3].preparation_time)
                .appendTo(l_tempo_c);
            var h3_preparazione = $('<h3 />')
                .text('Preparazione: ')
                .appendTo(l_tempo_p);
            var p = $('<p />')
                .text(data.recipes[3].description)
                .appendTo(l_tempo_p);
        });
    </script>
@endsection
