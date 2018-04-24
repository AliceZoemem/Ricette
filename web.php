<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('about', function(){
    return view('aboutus');
});

Route::get('/', function() {


    $vett_cibi=array('pasta', 'pizza','insalata', 'pollo', 'riso', 'torta', 'zuppa', 'verdura', 'pesce', 'formaggio', 'patate', 'spinaci', 'porchetta', 'spigola', 'tonno');

    for($i=0; $i < count($vett_cibi); $i++) {
        $url = 'http://www.giallozafferano.it/ricerca-ricette/' . $vett_cibi[$i];
        $crawler_ricerche = Goutte::request('GET', $url);
        $crawler_ricerche->filter('.sitewidth .format .loop .flex .title-recipe')->each(function ($node) {
            //filtro tutti i risultati delle rcerche fatte tramite il vettore dei cibi
            //node risulta ad ogni giro un nome di una ricetta diversa
            //la formattazione di una pagina di una ricetta e http://www.giallozafferano.it/Pasta-brise.html
            //riformulo quindi ogni node stampandolo con il dash separatore

            try {
                $node_withoutdelimiter= explode(" ", $node->text());
                $html='';
                //disassemblo e riassemblo i cibi trovati dalla ricerca nelle pagine e creo un link riassemblandoli
                for($x=0; $x < count($node_withoutdelimiter); $x++){
                    $html=$html . '-'.$node_withoutdelimiter[$x];
                }
                $html=$html. '.html';
                $html = ltrim($html, '-');
                $html='http://ricette.giallozafferano.it/' . $html;
            }catch(Exception $node_withoutdelimiter) {
                $html='http://ricette.giallozafferano.it/'. $node . '.html';
            }
            $crawler_ingredienti = Goutte::request('GET', $html);
            $crawler_ingredienti->filter('.format .recepy .right-push .intro .ingredienti .fs .ingredient ')->each(function ($ing) {
                if($ing->text() != 'Scopri i segreti per' | $ing->text() != 'una ' | $ing->text() != 'pasta perfetta ') {echo ($ing->text());}
                else{ echo('£');}
                //aggiungi al database
                //remove  Scopri i segreti peruna pasta perfetta

            });

        });
    }


});
