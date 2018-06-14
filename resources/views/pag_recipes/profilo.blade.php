@extends('master')
@section('title','Profilo - Tasty&Yummy')
@section('content')

    <form class="main-form" action="/change_profile" method="post">
        {{ csrf_field() }}
        <?php
            try{
                echo '<input type="text" class="lower form-control" id="nome" name="nome" placeholder="' . $information['name'] . '"/>';
                echo '<input type="text" class="lower form-control" id="cognome" name="cognome" placeholder="' . $information['surname'] . '"/>';
                echo '<input type="text" class="lower form-control" id="email" name="email" placeholder="' . $information['email'] . '"/>';
                echo '<input type="password" class="form-control" id="pw" name="pw" placeholder="password"/>';
                echo '<input type="password" class="form-control" id="conf-pw" name="conf-pw" placeholder="conferma password"/>';
                if($information['isAdmin'] == false)
                    echo '<p class="p-left">Non sei amministratore</p>';
                else
                    echo '<p class="p-left">Sei amministratore</p>';

            }catch(Exception $ex){

            }
        ?>

        <button type="submit" class="btn btn-warning" id="button_modifica">MODIFICA PROFILO</button>
    </form>
    <form class="main-form" action="/manage_crawler" method="post">
        {{ csrf_field() }}
        <?php
            try{
                echo $crawler;
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
