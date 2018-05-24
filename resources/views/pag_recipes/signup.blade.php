<?php
//    require_once('functions/functions.php');
//    $cookie_name= "auth_betaconvenzioni";
//    if(isset($_COOKIE[$cookie_name]))
//        header("Location: betaconvenzioni.php");
?>
@extends('master')

@section('title','Signup - Il mio frigo')

@section('content')

    <script>
        $(document).ready(function () {
            $('#rightmenu').hide();
            $('#header').hide();
        });
    </script>
    <input id="token_invisible" type="hidden" value="{{ csrf_token() }}">
    <div class="py-4 text-center">
        <img class="logo" src="/img/logo2.png" alt="" width="72" height="72">
        <h2>Registrati</h2>
        <p class="lead">Registrati anche tu. Entra nella community di Il mio frigo. Enjoy with food!</p>
    </div>

    <form id="MainForm" class="main-form" action="/trysignup" method="post">
        {{ csrf_field() }}
        <input type="text" id="nome" name="nome" class="form-control" id="txtNome" placeholder="Nome*" />
        <input type="text" id="cognome" name="cognome" class="form-control" id="txtCognome" placeholder="Cognome*" />
        <input type="text" id="email" name="email" class="form-control" id="txtEmail" placeholder="Email*" />
        <input type="password" id="pw" name="pw"class="form-control" id="txtPsw" placeholder="Password*" />
        <input type="password" id="confpw" name="confpw" class="form-control" id="txtConfPsw" placeholder="Conferma Password*" />
        <br/>
        <button class="btn btn-primary" name="submit" id="registrato">Registrati</button>
        <br/><br/>
        Sei già registrato? <a class="btn btn-link" href="login">Effettua il login</a><br/>
        <a class="btn btn-primary" href="index">Torna alla home </a>
    </form>
    <script>
        <?php
            try{echo $script;}catch(Exception $ex){}
        ?>
    </script>
@endsection
    <script>

//                var input = document.getElementById('txtIndirizzo');
//                var autocomplete = new google.maps.places.Autocomplete(input);
//            });
//
//            $("#MainForm").submit(function(e){
//                e.preventDefault();
//        $('#registrato').click(function () {
//            if ($('#txtNome').att() == "") {
//                $('#txtNome').addClass('needs-validation');
//                return;
//            }
//
//            if ($('#txtCognome').att() == "") {
//                $('#txtCognome').addClass('needs-validation');
//                return;
//            }
//
//
//            if ($('#txtConfPsw').att() == "")
//                $('#txtConfPsw').addClass('needs-validation');
//            if ($('#txtPsw').att() == "")
//                $('#txtPsw').addClass('needs-validation');
//            if ($('#txtEmail').att() == "")
//                $('#txtEmail').addClass('needs-validation');
//            var nome = $('#txtNome').att();
//            var cognome = $('#txtCognome').att();
//            var email = $('#txtEmail').att();
//            var pw = $('#txtPsw').att();
//            var pw = $('#txtConfPsw').att();
//
//            $.post("signup", {
//                _token: token_page,
//                'nome': nome,
//                'cognome': cognome,
//                'email': email,
//                'pw': pw
//            }, function (signup) {
//
//            });
//
//        });

//            function SignUp() {
//                var nome = $('#txtNome').val();
//                var cognome = $('#txtCognome').val();
//                var email = $('#txtEmail').val();
//                var psw = $('#txtPsw').val();
//                var indirizzo = $('#txtIndirizzo').val();
//                var regione = $('#ddlRegione').val();
//
//                $.ajax({
//                    url : 'functions/functions.php?function=SignUp',
//                    type : 'POST',
//                    data : {
//                        nome: nome,
//                        cognome: cognome,
//                        email: email,
//                        psw: psw,
//                        indirizzo: indirizzo,
//                        regione: regione
//                    },
//                    success : function(data) {
//                        data = getHtmlFreeResponse(data);
//                        data = JSON.parse(data);
//                        console.log(data);
//
//                        if(data.code == "200") {
//                            window.location.href = window.location.href;
//                        }
//                        else if(data.message == "no_name"){
//                            $('#txtNome').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#txtNome').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "no_surname"){
//                            $('#txtCognome').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#txtCognome').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "no_email"){
//                            $('#txtEmail').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#txtEmail').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "no_psw"){
//                            $('#txtPsw').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#txtPsw').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "no_address"){
//                            $('#txtIndirizzo').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#txtIndirizzo').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "no_region"){
//                            $('#ddlRegione').addClass('wrong-form-control');
//                            var flashInterval = setInterval(function() {
//                                $('#ddlRegione').removeClass('wrong-form-control');
//                            }, 500);
//                        }
//                        else if(data.message == "invalid_email"){
//                            $('#AlertMessage').text("L'indirizzo e-mail inserito non è valido. Inserire un'e-mail nel formato corretto.");
//                            $('#ModalAlert').modal('show');
//                        }
//                        else if(data.message == "email_exists"){
//                            $('#AlertMessage').text("L'indirizzo e-mail inserito è già in uso da un altro utente. Sceglierne un altro.");
//                            $('#ModalAlert').modal('show');
//                        }
//                        else {
//                            $('#AlertMessage').text("Ops, qualcosa è andato storto. Aspettare qualche minuto e riprovare.");
//                            $('#ModalAlert').modal('show');
//                        }
//                    },
//                    error : function(request, error) {
//                        console.log("Error", request, error);
//                    }
//                });
//            }


//            function getCookie(name) {
//                var value = "; " + document.cookie;
//                var parts = value.split("; " + name + "=");
//                if (parts.length == 2) return parts.pop().split(";").shift();
//            }
//
//
//            String.prototype.replaceAll = function(str1, str2, ignore)
//            {
//                return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
//            }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
//        (function() {
//            'use strict';
//
//            window.addEventListener('load', function() {
//                // Fetch all the forms we want to apply custom Bootstrap validation styles to
//                var forms = document.getElementsByClassName('needs-validation');
//
//                // Loop over them and prevent submission
//                var validation = Array.prototype.filter.call(forms, function(form) {
//                    form.addEventListener('submit', function(event) {
//                        if (form.checkValidity() === false) {
//                            event.preventDefault();
//                            event.stopPropagation();
//                        }
//                        form.classList.add('was-validated');
//                    }, false);
//                });
//            }, false);
//        })();
</script>