@extends('master')
@section('title','Profilo - Tasty&Yummy')
@section('content')

    <form class="main-form" action="/change_profile" method="post">
        {{ csrf_field() }}
        <h1>INFORMAZIONI PROFILO</h1>
        <?php
            try{
                echo '<input type="text" class="lower form-control" id="nome" name="nome" placeholder="' . $information['name'] . '"/>';
                echo '<input type="text" class="lower form-control" id="cognome" name="cognome" placeholder="' . $information['surname'] . '"/>';
                echo '<input type="text" class="lower form-control" id="email" name="email" placeholder="' . $information['email'] . '"/>';
                echo '<input type="password" class="form-control" id="pw" name="pw" placeholder="Password"/>';
                echo '<input type="password" class="form-control" id="conf-pw" name="conf-pw" placeholder="Conferma Password"/>';
                if($information['isAdmin'] == false)
                    echo '<p class="p-left">Non sei amministratore</p>';
                else
                    echo '<p class="p-left">Sei amministratore</p>';

            }catch(Exception $ex){

            }
        ?>

        <button type="submit" class="btn btn-outline-warning" id="button_modifica">MODIFICA PROFILO</button>
    </form>

    <form id="echo_change" class="form_new ricettario" action="/ricettario" method="post">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-warning" id="ricettario">RICETTARIO PERSONALE</button>
    </form>



    <form class="form_new" action="/manage_crawler" method="post">
        {{ csrf_field() }}
        <?php
            try{
                if($crawler != '')
                    echo $crawler;
                else{
                    echo '<script>$("#echo_change").removeClass("ricettario");</script>';
                    echo '<script>$("#echo_change").addClass("ricettario2");</script>';
                }
            }catch(Exception $ex){
            }
        ?>
    </form>


    <script>
        <?php
            try{
                echo $script;
            }catch(Exception $ex){
            }
        ?>
    </script>
@endsection
