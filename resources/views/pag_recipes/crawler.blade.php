@extends('master')
@section('title','Crawler - Tasty&Yummy')
@section('content')
    </br>
    <a href="/crawler">
        <button class="btn btn-outline-danger" >AVVIA IL CRAWLER</button>
    </a>
    <?php
        try{
            echo '<p class="ricette_ottenute">'.$info.'</p>';
        }catch(Exception $ex){

        }
    ?>
    <div class="table-column">
    <?php
        try{
            $conta = 0;
            foreach ($lista_cibi as $key => $cibo){
                if($cibo != ""){
                    if($conta % 4 == 0){
                       echo '<div class="row">';
                    }
                    echo '<div class="col-sm inherit">';
                    echo '<p>'.$cibo .'</p>';
                    echo '<a href="/delete_category/' . $key . '">';
                    echo '<button id="category'.$key. '" name="category" class="btn btn-white" type="submit" style="font-size: 13px">x</button>';
                    echo '</a>';
                    echo '</div>';
                    if($conta % 4 == 3){
                       echo '</div>';
                    }
                    $conta ++;
                }
            }
            if($conta % 4 == 3){
                echo '<div class="col-sm inherit"></div></div>';
            }
            if($conta % 4 == 2){
                dd($conta % 4);
                echo '<div class="col-sm inherit"></div>';
                echo '<div class="col-sm inherit"></div>';
                echo '</div>';
            }
            if($conta % 4 == 1){
                echo '<div class="col-sm inherit"></div>';
                echo '<div class="col-sm inherit"></div>';
                echo '<div class="col-sm inherit"></div>';
                echo '</div>';
            }


        }catch(Exception $ex){
        }
    ?>
    </div>
    <br/>
    <form class="main-form" action="/add_category" method="post">
        {{ csrf_field() }}
        <input id="add_category" type="text" name="add_category" class="lower form-control" placeholder="Categoria"/>
        <button type="submit" class="btn btn-warning" id="add_category">AGGIUNGI CATEGORIA AL CRAWLER</button>
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
