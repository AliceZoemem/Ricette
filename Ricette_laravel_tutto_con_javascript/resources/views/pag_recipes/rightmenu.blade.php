<style>
    #rightmenu{
        float: right;
    }
    .rightm {
        overflow: hidden;
        background-color: #333;
    }

    .rightm a {
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .rightm a:hover {
        background-color: #ddd;
        color: black;
    }

    .rightm .icon {
        display: none;
    }

    @media screen and (max-width: 600px) {
        .rightm a:not(:first-child) {display: none;}
        .rightm a.icon {
            float: right;
            display: block;
        }
    }

    @media screen and (max-width: 600px) {
        .rightm.responsive {position: relative;}
        .rightm.responsive.icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .rightm.responsive a {
            float: right;
            display: block;
            text-align: left;
        }

    }
</style>

<script type="text/javascript">

    function respo() {
        var x = document.getElementById("rightmenu");
        if (x.className === "rightm") {
            x.className += " responsive";
        } else {
            x.className = "rightm";
        }
    }

    $.get("api/recipes/5", function (data){
        i = 0;
        data.recipes.forEach( function(single_recipe){
            i+= 1;
            var cList = $('#rightmenu');
            var aaa = $('<a />')
            .attr("href", 'http://localhost/' + i)
            .text(single_recipe.name_recipe)
            .appendTo(cList);
        });
    });

    //aggiungi img
</script>

<div id="rightmenu" class="rightm" >

    <a id="intro">Ultime 5 ricette inserite</a>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="respo()">&#9776;</a>

</div>