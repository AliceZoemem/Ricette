<style>
    .topmenu {
        overflow: hidden;
        background-color: #333;
    }

    .topmenu a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topmenu a:hover {
        background-color: #ddd;
        color: black;
    }

    .topmenu .icon {
        display: none;
    }

    @media screen and (max-width: 600px) {
        .topmenu a:not(:first-child) {display: none;}
        .topmenu a.icon {
            float: right;
            display: block;
        }
    }

    @media screen and (max-width: 600px) {
        .topmenu.responsive {position: relative;}
        .topmenu.responsive.icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .topmenu.responsive a {
            float: none;
            display: block;
            text-align: left;
        }

    }
</style>

<div class="topmenu" id="Menu">
    <a href="/">Home</a></li>
    <a href="all">Tutte le ricette</a>
    <a href="oneperson">Ricette per 1</a>
    <a href="#">Contatti</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="respo()">&#9776;</a>
</div>
<script>
function respo() {
        var x = document.getElementById("Menu");
    if (x.className === "topmenu") {
        x.className += " responsive";
    } else {
          x.className = "topmenu";
      }
    }
</script>

