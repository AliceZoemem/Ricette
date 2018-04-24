@extends('master')
@section('title','Contatti - Il mio frigo')
@section('content')
    <style>

    /*.column {*/
        /*float: left;*/
        /*width: 33.3%;*/
        /*margin-bottom: 16px;*/
        /*padding: 0 8px ;*/
        /*font-size: 100%;*/
    /*}*/
    /*.contatto_info {*/
        /*text-align: center;*/
        /*width: 33.3%;*/
        /*margin-bottom: 3%;*/

    /*}*/
    /*.title{*/
        /*text-align: center;*/
        /*width: 33.3%;*/
        /*margin-bottom: 3%;*/
    /*}*/
    /*h2{*/
        /*text-align: center;*/
        /*width: 33.3%;*/
        /*margin-bottom: 3%;*/
    /*}*/

    /*@media (max-width: 650px) {*/
        /*.column {*/
            /*width: 100%;*/
            /*display: block;*/
        /*}*/
        /*.contatto_info {*/
            /*text-align: center;*/
            /*width: 100%;*/
            /*display: block;*/
            /*margin-bottom: 3%;*/

        /*}*/
        /*.title{*/
            /*text-align: center;*/
            /*width: 100%;*/
            /*display: block;*/
            /*margin-bottom: 3%;*/
        /*}*/
        /*h2{*/
            /*text-align: center;*/
            /*width: 100%;*/
            /*display: block;*/
            /*margin-bottom: 3%;*/
        /*}*/
        /*.button {*/
            /*border: none;*/
            /*outline: 0;*/
            /*display: inline-block;*/
            /*padding: 8px;*/
            /*color: white;*/
            /*background-color: #000;*/
            /*text-align: center;*/
            /*cursor: pointer;*/
            /*width: 90%;*/
        /*}*/

    /*}*/

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        position: relative;
        text-align: center;
        width: 100%;
    }

    .container {
        padding: 0 16px;
        width: 50%;
    }

    /*.container::after, .row::after {*/
        /*content: "";*/
        /*clear: both;*/
        /*display: table;*/
    /*}*/

    /*.title {*/
        /*color: grey;*/
    /*}*/

    /*.button {*/
        /*border: none;*/
        /*outline: 0;*/
        /*display: inline-block;*/
        /*padding: 8px;*/
        /*color: white;*/
        /*background-color: #000;*/
        /*text-align: center;*/
        /*cursor: pointer;*/
        /*float: left;*/
        /*width: 30%;*/
    /*}*/

    /*.button:hover {*/
        /*background-color: #555;*/
    /*}*/
    </style>
    </head>
    <body>


    <div class="row">
        <div class="column">
            <div class="card">
                <div class="container">
                    <img url="/img/ali.jpg" alt="img" style="width:100%">
                    <br/>
                    <h2>Alice Albertin</h2>
                    <p class="title">Founder & Developer</p>
                    <p class="contatto_info">During the graduate period Alice had the idea to open a new social platform where people could share their recipe and new invenction of the world of the cuisine
                        </br>  For more info </br>alicealbertin90@gmail.com</p>

                    <button class="button">Contact</button>
                </div>
            </div>
        </div>
    </div>
@endsection