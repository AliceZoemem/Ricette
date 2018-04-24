<section class="menulateraledestro">

    <style>

    </style>
    <div id="rightmenu" class="rightm">

            <li class="disappare">
                <a href="/singlerecipe/181"><u>le tortillas di farina</u>
                    <img src="http://www.giallozafferano.it/images/ricette/6/631/foto_hd/hd650x433_wm.jpg">
                </a></br></br>
            </li>
            <li class="disappare">
                <a href="/singlerecipe/15"><u>la pizza senza glutine</u>
                    <img src="http://www.giallozafferano.it/images/ricette/16/1655/foto_hd/hd650x433_wm.jpg">
                </a></br></br>
            </li>
            <li class="disappare">
                <a href="/singlerecipe/117"><u>i samosa di tonno</u>
                    <img src="http://www.giallozafferano.it/images/ricette/178/17838/foto_hd/hd650x433_wm.jpg">
                </a></br></br>
            </li>
            <li class="disappare">
                <a href="/singlerecipe/104"><u>lo strudel con ricotta e spinaci</u>
                    <img src="http://www.giallozafferano.it/images/ricette/2/268/foto_hd/hd650x433_wm.jpg">
                </a></br></br>
            </li>
            <li class="disappare">
                <a href="/singlerecipe/56"><u>la zuppa di noodles</u>
                    <img src="http://www.giallozafferano.it/images/ricette/36/3603/foto_hd/hd650x433_wm.jpg">
                </a></br></br>
            </li>

        <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="respo()">
            <img id="hidden_cake" src="img/recipes1.png" style="width: 12%; height: 7%; float:right; margin-top: 1%;  margin-right: 1%"/>
        </a>
    </div>
</section>

<script>
//    function respo() {
//        var x = document.getElementById("Menu");
//        if (x.className === "topmenu") {
//            x.className += " responsive";
//            //take the span class and convert
//        } else {
//            x.className = "topmenu";
//        }
//    }
    $(document).open(function(){
        alert('ora');
        $('#hidden_cake').hide();
    });
    $(document).ready(function(){
        alert('poi');
        $('#hidden_cake').hide();
        if($(window).width() < 960){
            $('#hidden_cake').hide();
            $('.disappare').hide();
        }
    });
    function respo(){
        //change class to convert style
        $('.disappare').show();
    }
</script>

