@extends('master')
@section('title','Crawler - Tasty&Yummy')
@section('content')

    <form class="main-form" action="/change_profile" method="post">
        {{ csrf_field() }}
        <?php
        try{
           foreach ($lista_cibi as $cibo){
               echo '<p>'.$cibo .'</p>';
           }

        }catch(Exception $ex){
        }
        ?>

        <button type="submit" class="btn btn-warning" id="button_modifica">MODIFICA PROFILO</button>
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
