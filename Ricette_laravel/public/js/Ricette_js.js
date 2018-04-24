/**
 * Created by alice on 10/07/17.
 */
var apparsa_div_ingredienti = false;
var ingredienti_inseriti = Array();
var inizio = true;
var slide = true;
var i= 0;

$(document).ready(function() {
    $( "#ingrediente" ).autocomplete({
        source: globalIngredients
    });
} );

// $(document).ready(function() {
//     $( "#prova_ids" ).value({
//         source: idsrecipesresults
//     });
// } );


function start(){
    document.getElementById('inserisci_ingredienti').style.visibility= 'hidden';
    document.getElementById('inserisci_ingredienti').style.display='none';
    document.getElementById('ingrediente').value = 'Aggiungi un ingrediente...';
    $.get("rightmenu" , {_token: token_page}, function (randomrecipes){});
    i = 0;
}

function aggiungi() {
    var new_ingredient = document.getElementById('ingrediente').value;
    
    //token cambio pagina {{ csrf_field() }} usando il form a fronte della chiamata cambio pagina
    var token_page = document.getElementById('token_invisible').value;
    $.post("ingredients_database", {_token: token_page, 'ingredient': new_ingredient}, function (ingrediente_accettato) {
        if (ingrediente_accettato == 'si') {
            if (inizio == true) {
                inizio = false;
                var crea_bottone_cerca = document.createElement("BUTTON");
                var scritta_bottone_cerca = document.createTextNode('CERCA');
                crea_bottone_cerca.setAttribute("id", "btncerca");
                crea_bottone_cerca.setAttribute("style", "font-size: 17px");
                crea_bottone_cerca.setAttribute("onclick", "cerca_ricetta()");
                crea_bottone_cerca.appendChild(scritta_bottone_cerca);
                document.getElementById("avvia").insertBefore(crea_bottone_cerca, document.getElementById("btncerca"));
                // tabspace.innerHTML = "&nbsp";
                // crea_bottone_cerca.appendChild(tabspace);
                var crea_label_match = document.createElement("LABEL");
                var scritta_label_trovate = document.createTextNode('Ricette trovate: null');
                crea_label_match.setAttribute("id", "trovato");
                crea_label_match.appendChild(scritta_label_trovate);
                document.getElementById("avvia").insertBefore(crea_label_match, document.getElementById("trovato"));
            }

            if (slide == true) {
                $("#inserisci_ingredienti").slideDown();
                slide = false;
            }
            crea(new_ingredient, ingredienti_inseriti);
        }
    });

}
//$.post("give_ingredient",{ 'add_ingredient' : new_ingredient , _token : token_page});

function crea(new_ingredient, ingredienti_inseriti) {
    var inserisci = true;
    ingredienti_inseriti.forEach(function( ingrediente){
        if(ingrediente == new_ingredient){
            inserisci = false;
        }
    })
    if(new_ingredient != '' && inserisci == true)
    {
        document.getElementById('inserisci_ingredienti').style.visibility= 'visible';
        document.getElementById('inserisci_ingredienti').style.display='block';
        ingredienti_inseriti.push(new_ingredient);
        var crea_label = document.createElement("LI");
        var scritta_label = document.createTextNode(new_ingredient);
        crea_label.setAttribute("id", "ing" + i);
        crea_label.setAttribute("class", "ingrediente_inserito");
        crea_label.appendChild(scritta_label);
        document.getElementById("lista_ing").insertBefore(crea_label,document.getElementById("ing" + i));

        var crea_bottone = document.createElement("BUTTON");
        var scritta_bottone = document.createTextNode('x');
        crea_bottone.setAttribute("id", "btn" + i);
        crea_bottone.setAttribute("style", "font-size: 13px");
        crea_bottone.setAttribute("onclick", "rimuovi(" + i + ")");
        crea_bottone.appendChild(scritta_bottone);
        document.getElementById("ing" + i).insertBefore(crea_bottone,document.getElementById("btn" + i));
        document.getElementById('ingrediente').value = '';
        i++;
    }
}


function rimuovi(i) {
        visible = false;
        document.getElementById('ing' + i).style.visibility= 'hidden';
        document.getElementById('ing' + i).style.display='none';
        document.getElementById('btn' + i).style.visibility='hidden';
        document.getElementById('btn' + i).style.display='none';
        delete ingredienti_inseriti[i];
        ingredienti_inseriti.forEach(function ($ingredienti){
            if($ingredienti != null){
                visible = true;
            }
        });
        if(visible == false){
            slide = true;
            document.getElementById('inserisci_ingredienti').style.visibility= 'hidden';
            document.getElementById('inserisci_ingredienti').style.display='none';
        }
}


function cerca_ricetta(){
    var token_page = document.getElementById('token_invisible').value;
    $.post("give_ingredient" , {_token: token_page, 'ingredients' : ingredienti_inseriti}, function (ids_ricette){

    });

    location.replace('results');

}

