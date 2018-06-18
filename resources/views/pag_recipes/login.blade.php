@extends('master')
@section('title','Login - Tasty&Yummy')
@section('content')
    <script>
        $(document).ready(function () {
            $('#rightmenu').hide();
            $('#btn_cake').hide();
            $('.rightmenu_colonna').hide();
            $('#header').hide();
        });
        window.onresize = function() {
            $('#rightmenu').hide();
            $('.rightmenu_colonna').hide();
        }
    </script>

    <style>
        .content{
            width: 100%;
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

        @media screen and (max-width: 990px) {
            .content{
                margin-top: 0%;
            }
        }
    </style>


    <div class="py-4 text-center">
        <img class="logo" src="/img/logo2.png" alt="" width="72" height="72">
        <h2>Accedi</h2>
        <p class="lead">Accedi anche tu. Entra nella community di Tasty&Yummy. Enjoy with food!</p>
    </div>

    <form method="POST" action="/trylog" class="main-form">
        {{ csrf_field() }}
        <input id="email" type="text" name="email" class="lower form-control" placeholder="Email">
        <input id="pw" type="password" name="pw" class="form-control" placeholder="Password">
        <br/>
        <button type="submit" class="btn btn-primary">Login</button>
        <br/><br/>

        Non sei ancora registrato? <a class="btn btn-link" href="signup">Registrati</a>
        <br/>
        <a class="btn btn-warning" href="index">Torna alla home </a>
    </form>
    <script>
        <?php
            try{echo $script;}catch(Exception $ex){}
        ?>
    </script>
@endsection

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

