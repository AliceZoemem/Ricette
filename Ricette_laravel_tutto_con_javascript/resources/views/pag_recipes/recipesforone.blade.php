@extends('master')
@section('title','Ricette per uno - Il mio frigo')
@section('content')

    <div id="ricette_per_uno" >

    </div>

    <script type="text/javascript">
        $.get( "/api/recipes", function(data) {

            data.recipes.forEach(function (ricetta_db, i){
                //crea prima una div per la foto
                if(data.recipes[i].doses_per_person == '4 persone' | data.recipes[i].doses_per_person == '2 pezzi')
                {
                    var cdiv = $('#ricette_per_uno');
                    var h1 = $('<h1 />')
                        .text(data.recipes[i].name_recipe)
                        .appendTo(cdiv);
                    var l_diff = $('<li />')
                        .text('difficolta: ' + data.recipes[i].difficulty)
                        .appendTo(cdiv);
                    var l_dosi = $('<li />')
                        .text('dosi: ' + data.recipes[i].doses_per_person)
                        .appendTo(l_diff);
                    var l_tempo_c = $('<li />')
                        .text('tempo di cottura: ' + data.recipes[i].cooking_time)
                        .appendTo(l_dosi);
                    var l_tempo_p = $('<li />')
                        .text('tempo di preparazione: ' + data.recipes[i].preparation_time)
                        .appendTo(l_tempo_c);
                    var h3_preparazione = $('<h3 />')
                        .text('Preparazione: ')
                        .appendTo(l_tempo_p);
                    var p = $('<p />')
                        .text(data.recipes[i].description)
                        .appendTo(l_tempo_p);
                    var a_capo = $('</br>')
                        .appendTo(cdiv);
                    var a_capo2 = $('</br>')
                        .appendTo(cdiv);
                }
            });
        });
    </script>
@endsection