@extends('master')

@section('title','Signup - Il mio frigo')

@section('content')
    <style>
        .content{
            width: 100%;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#rightmenu').hide();
            $('#header').hide();
        });
    </script>
    <input id="token_invisible" type="hidden" value="{{ csrf_token() }}">
    <div class="py-4 text-center">
        <img class="logo" src="/img/logo2.png" alt="" width="72" height="72">
        {{--<img class="logo" src="/img/l13.jpg" alt="" width="190" height="190">--}}
        <h2>Registrati</h2>
        <p class="lead">Registrati anche tu. Entra nella community di Il mio frigo. Enjoy with food!</p>
    </div>

    <form id="MainForm" class="main-form" action="/trysignup" method="post">
        {{ csrf_field() }}
        <input type="text" id="nome" name="nome" class="lower form-control" id="txtNome" placeholder="Nome*" />
        <input type="text" id="cognome" name="cognome" class="lower form-control" id="txtCognome" placeholder="Cognome*" />
        <input type="text" id="email" name="email" class="lower form-control" id="txtEmail" placeholder="Email*" />
        <input type="password" id="pw" name="pw"class="form-control" id="txtPsw" placeholder="Password*" />
        <input type="password" id="confpw" name="confpw" class="form-control" id="txtConfPsw" placeholder="Conferma Password*" />
        <br/>
        <button class="btn btn-primary" name="submit" id="registrato">Registrati</button>
        <br/><br/>
        Sei già registrato? <a class="btn btn-link" href="login">Effettua il login</a><br/>
        <a class="btn btn-warning" href="index">Torna alla home </a>
    </form>
    <script>
        <?php
            try{echo $script;}catch(Exception $ex){}
        ?>
    </script>
@endsection