@extends('master')
@section('title','Tutte le ricette - Il mio frigo')
@section('content')
    <script>
        function inputFocus(i){
            if(i.value==i.defaultValue){ i.value=""; i.style.color="#000"; }
        }
        function inputBlur(i){
            if(i.value==""){ i.value=i.defaultValue; i.style.color="#888"; }
        }

    </script>
    <div id="body">
        <button id="search" class="glyphicon glyphicon-search" function="cerca_all()">
        </button>
        <a class="text-muted" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
        </a>
        <input type="text" value="Ricerca.." style="color:#888;" id="ricerca"
               onfocus="inputFocus(this)" onblur="inputBlur(this)"/></br>
        <div id="ricette_db">
            @foreach ($ricette as $singola_ricetta)
                dd($singola_ricetta);
                <h1><a href="{{$singola_ricetta['id']}}">
                        <u>{{$singola_ricetta['id']->name_recipe}}</u>
                    </a></h1>
                <img src="{{$singola_ricetta['id']->recipe_img}}" alt="{{$singola_ricetta->name_recipe}}">
                <li> difficolta: {{$singola_ricetta['id']->difficulty}}</li>
                <li> dosi: {{$singola_ricetta['id']->doses_per_person}}</li>
                <li> tempo di cottura: {{$singola_ricetta['id']->cooking_time}}</li>
                <li> tempo di preparazione: {{$singola_ricetta['id']->preparation_time}}</li>
                </br></br>
            @endforeach
        </div>
    </div>
@endsection