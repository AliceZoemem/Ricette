/**
 * Created by alice on 10/07/17.
 */
var slide = true;
var i= 0;
var hide = 0;
var rightmenu_visible = 0;


window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollup").style.display = "block";
    } else {
        document.getElementById("scrollup").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}