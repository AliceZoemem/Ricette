<section class="menualto">
    <div class="topmenu" id="Menu">
        <ul class="nav navbar-nav navbar-left">

            <li><a id="homo" href="/signup"><span class="glyphicon glyphicon-user"></span><label id="label_hidden">Sign Up</label></a></li>
            <li><a id="enter" href="/login"><span class="glyphicon glyphicon-log-in"></span><label id="label_hidden"> Login</label></a></li>
        </ul>
        <li class="disappare"> <a href="/">Home</a></li>
        <li class="disappare"> <a href="/all">Tutte le ricette</a></li>
        <li class="disappare"> <a href="/twopeople">Ricette per 2</a></li>
        <li class="disappare"> <a href="/contact">Contatti</a></li>

        <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="respo()">&#9776;</a>
    </div>
</section>

<script>
function respo() {
        var x = document.getElementById("Menu");
    if (x.className === "topmenu") {
        x.className += " responsive";
        //take the span class and convert
    } else {
          x.className = "topmenu";
      }
    }
</script>


