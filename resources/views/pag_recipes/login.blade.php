<?php
    $cookie_name= "auth_betaconvenzioni";
    if(isset($_COOKIE[$cookie_name]))
        header("Location: /homepage.php");
?>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="description" content="Recipe site">
        <meta name="author" content="Albertin Alice">
        <link href="https://fonts.googleapis.com/css?family=Oswald|Raleway" rel="stylesheet">
        <link href='{{ asset('/css/style.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/bootstrap.css') }}' rel='stylesheet' type='text/css'>
        <link href='{{ asset('/css/bootstrap.min.css') }}' rel='stylesheet' type='text/css'>
        <script src="{{ asset('/js/bootstrap.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <title>Login - Il mio frigo</title>
        <style>
            body{
                /*font-family: 'Oswald', sans-serif;*/
                font-family: 'Raleway', sans-serif;
                padding-top:70px;
            }
            .main-form{
                width:60%;
                margin-left:20%;
                text-align:center;
            }
            .main-form .form-control{
                margin-bottom:5px;
            }
            .main-form .logo{
                max-width:50%;
                max-height:250px;
                display:inline-block;
            }
            @media all and (max-width: 600px) {
                .main-form{
                    width:90%;
                    margin-left:5%;
                }
            }
        </style>
    </head>

    <body>
        <div class="py-4 text-center">
            <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h2>Registrati</h2>
            <p class="lead">Registrati anche tu. Entra nella community di Il mio frigo. Enjoy with food!</p>
        </div>
        <form method="post" action="login" class="main-form">
            <input type="text" name="email" class="form-control" placeholder="Email">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <br/>
            <button class="btn btn-primary" onclick="LogIn();">Login</button>
            <br/><br/>
            Non sei ancora registrato? <a class="btn btn-link" href="signup">Registrati</a>
        </form>

        <div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="titleLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titleLabel">Attenzione</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Credenziali errate. Riprovare.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
    //    require_once('functions/functions.php');
    //    $conn = InstauraConnessione();
    //
    //    if ( isset($_POST['submit'] )){
    //        $email = $_POST['email'];
    //        $pw = $_POST['password'];
    //
    //        $new_pw = md5($pw);
    //
    //        $sql = "SELECT * FROM tbl_utenti WHERE password = '" . $new_pw ."' AND email = '" . $email ."' AND attivo = '1'" ;
    //        $result = $conn->query($sql);
    //
    //        if ($result->num_rows > 0) {
    //            $row = mysqli_fetch_row($result);
    //            $cookie_value = Encryption($row[0], 'e');
    //            $cookie_name = 'auth_betaconvenzioni';
    //
    //            setcookie ($cookie_name, $cookie_value, time() + (86400 * 30), '/');
    //            AbbattiConnessione($conn);
    //            header("Location: betaconvenzioni.php");
    //
    //            //se il cookie e settato e torno a login reindirizza su homepage
    //        }else{
    //            echo "<script>$('#ModalAlert').modal('show');</script>";
    //            AbbattiConnessione($conn);
    //        }
    //    }
    ?>
</html>

