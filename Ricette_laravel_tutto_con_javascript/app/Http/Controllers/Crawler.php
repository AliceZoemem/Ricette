<?php
    namespace App\Http\Controllers;

    use App\Ingredient;
    use App\Recipe;
    use Illuminate\Support\Facades\DB;
    use Goutte;
    use Illuminate\Validation\Rules\In;

    class Crawler extends Controller
    {
        public function getrecipes(){
            $ricette_ottenute = 0;
            $id_ricette = array();
            $vett_cibi=array(
                'pasta',
                'pizza',
                'insalata',
                'pollo',
                'riso',
                'torta',
                'zuppa',
                'verdura',
                'pesce',
                'formaggio',
                'patate',
                'spinaci',
                'porchetta',
                'spigola',
                'tonno',
                'salsiccia',
                'prosciutto',
                'pomodori',
                'gamberetti',
                'limone',
                'ceci',
                'legumi',
                'farina',
                'minestra',
                'fragole' ,
                'cocco',
                'frutta',
                'gelato',
                'mousse',
                'vegano',
                'maiale',
                'anatra'
            );
            foreach($vett_cibi as $cibo) {
                $url = 'http://www.giallozafferano.it/ricerca-ricette/' . $cibo;
                $crawler_ricerche = Goutte::request('GET', $url);
                $id_ricette = $crawler_ricerche->filter('.sitewidth .format .loop .flex .title-recipe')->each(function ($node) {
                    //filtro tutti i risultati delle rcerche fatte tramite il vettore dei cibi
                    //node risulta ad ogni giro un nome di una ricetta diversa
                    //la formattazione di una pagina di una ricetta e http://www.giallozafferano.it/Pasta-brise.html
                    //riformulo quindi ogni node stampandolo con il dash separatore
                    try {
                        $node_withoutdelimiter = explode(" ", $node->text());
                        $html = '';
                        //disassemblo e riassemblo i cibi trovati dalla ricerca nelle pagine e creo un link riassemblandoli
                        for ($x = 0; $x < count($node_withoutdelimiter); $x++)
                            $html = $html . '-' . $node_withoutdelimiter[$x];

                        $html = $html . '.html';
                        $html = ltrim($html, '-');
                        $html = 'http://ricette.giallozafferano.it/' . $html;
                    } catch (Exception $node_withoutdelimiter) {
                        $html = 'http://ricette.giallozafferano.it/' . $node . '.html';
                    }

                    //devo prendere una ricetta e tenermi l id in una collection
                    // salvo nel db la ricetta
                    // salvo nel db gli ingredienti
                    // c'e' gia?
                    //cerco id per nome lo stesso
                    //salto
                    // salvo ing e id

                    $vett_pivot_ricette = array();
                    $array_ingredienti = get_ingredients($html);
                    $array_id_ingredienti = get_id_ingredients($array_ingredienti, $html, $array_ingredienti);
                    tb_ricette($html, $array_id_ingredienti, $array_ingredienti);


                });

            }

            $find = Recipe::count();
            return 'Success for '.$find .' new different recipes';
        }
    }


    function tb_ricette($html_ricerca, $array_id_ingredienti, $array_ingredienti)
    {
        $vett_id_ricette = array();
        $prendi_pagina = Goutte::request('GET', $html_ricerca);
        //'.costo'
        $ricerca_specifica_requisiti = array('.difficolta', '.preptime', '.cooktime', '.yield');
        $field = array('difficulty', 'preparation_time', 'cooking_time', 'doses_per_person');
        $i = 0;
        foreach ($ricerca_specifica_requisiti as $specifica){
            $filtro_ricerca = '.format .recepy .right-push .intro .jus .rInfos ' .$specifica;
            $requisiti_ottenuti = $prendi_pagina->filter($filtro_ricerca)->each(function ($requisiti_item) {
                $requisiti_str = $requisiti_item->text();
                $requisiti_str = preg_replace("/\t/", '', $requisiti_str);
                $requisiti_str = preg_replace("/\n/", '', $requisiti_str);
                $requisiti_str = trim($requisiti_str);

                if($requisiti_str != null){
                    return $requisiti_str;
                }
            });

            if($requisiti_ottenuti != null){
                $requisiti_ottenuti[0] =  str_replace( "Difficoltà:", "", $requisiti_ottenuti[0]);
                $requisiti_ottenuti[0] =  str_replace( "Preparazione:", "", $requisiti_ottenuti[0]);
                $requisiti_ottenuti[0] =  str_replace( "Cottura:", "", $requisiti_ottenuti[0]);
                $requisiti_ottenuti[0] =  str_replace( "Dosi per:", "", $requisiti_ottenuti[0]);
                //$requisiti_ottenuti[0] =  str_replace( "Costo:", "", $requisiti_ottenuti[0]);
                $vett_requisiti[$field[$i]] = $requisiti_ottenuti[0];
                $i += 1;
                if($i == 4){
                    $inserisci_database = true;

                    $name_ric = substr_replace (preparazione($prendi_pagina),0, strpos(preparazione($prendi_pagina), '£'));
                    $vett_requisiti['name_recipe'] = str_replace("0" , "", $name_ric);
                    $descrizione = substr_replace (preparazione($prendi_pagina),'', 0, strpos(preparazione($prendi_pagina), '£'));
                    $descrizione = str_replace("£ ", "", $descrizione);
                    $vett_requisiti['description'] = $descrizione;
                    $controlla_inserimento = Recipe::where('difficulty', $vett_requisiti['difficulty'])->where('preparation_time', $vett_requisiti['preparation_time'])->where('cooking_time', $vett_requisiti['cooking_time'])->where('doses_per_person', $vett_requisiti['doses_per_person'])->where('description', $vett_requisiti['description'])->get();
                    if($controlla_inserimento->isEmpty()){
                        $ricetta = new Recipe();
                        $ricetta->difficulty = strtolower($vett_requisiti['difficulty']);
                        $ricetta->preparation_time = strtolower($vett_requisiti['preparation_time']);
                        $ricetta->cooking_time = strtolower($vett_requisiti['cooking_time']);
                        $ricetta->doses_per_person = strtolower($vett_requisiti['doses_per_person']);
                        $ricetta->name_recipe = strtolower($vett_requisiti['name_recipe']);
                        $ricetta->description = strtolower($vett_requisiti['description']);
                        $ricetta->save();

                        $vett_amount = quantita_ingredienti($html_ricerca, $array_ingredienti);
                        $new_array_insert = array();
                        $x = 0;
                        foreach ($array_id_ingredienti as $id_ingredient){
                            $new_array_insert[$id_ingredient]['amount'] = $vett_amount[$x] ;
                            $x += 1;
                        }
                        $ricetta->ingredients()->attach($new_array_insert);//attach appende al db una riga la sync invece pulisce le righe gia inserite e parte dall inizio


                        $ricetta->save();
                    }
                }
            }
        }
    }


    function preparazione($prendi_pagina){
        $descrizione = '';
        $vett_prep = $prendi_pagina->filter('.sitewidth .format .recepy .right-push > p')->each(function ($preparazione) {
            $preparazione_str=$preparazione->text();
            $preparazione_str = preg_replace("/\t/", '', $preparazione_str);
            $preparazione_str = preg_replace("/\n/", '', $preparazione_str);
            $preparazione_str=trim ( $preparazione_str);
            $pos_commento = strpos($preparazione_str, 'comment');
            if($pos_commento == null ){
                return $preparazione_str;
            }
        });
        $name = $prendi_pagina->filter('.sitewidth .format .recepy .right-push .sez >h2')->each(function ($nome_ricetta) {
            return(str_replace('Come preparare ','' , $nome_ricetta->text()));
        });

        if($name != null)
            $descrizione = $name[0].'£';
        foreach ($vett_prep as $parte_preparazione){
            $descrizione = $descrizione . ' ' .$parte_preparazione;
        }
        return $descrizione;
    }


    function get_ingredients($html_ricerca)
    {
        $vett_ing = array();
        $crawler = Goutte::request('GET', $html_ricerca);
        $vett_ing = $crawler->filter('.format .recepy .right-push .intro .ingredienti .fs .ingredient >a')->each(function ($ing){
            $ing_str = $ing->text();
            $ing_str = preg_replace("/\t/", '', $ing_str);
            $ing_str = preg_replace("/\n/", '', $ing_str);
            $ing_str = trim($ing_str);
            return $ing_str;
        });
        if($vett_ing != null)
            return $vett_ing;

    }


    function get_id_ingredients($vett_ing, $html_ricerca)
    {
        $vett_id_ing = array();
        $tipi_pasta = array('Rigatoni', 'Farfalle', 'Spaghetti N°5', 'Fusilli', 'Pipe Rigate');
        if($vett_ing != null) {
            $cambia = false;
            $vett_quantita = quantita_ingredienti($html_ricerca, $vett_ing);
            foreach ($vett_ing as $name){
                foreach ($tipi_pasta as $pasta){
                    if($name == $pasta){
                        $name = $name .'/pasta';
                    }
                }
                $find = Ingredient::where('name', $name)->get();
                if($find->isEmpty()){
                    $ingred = new Ingredient();
                    $ingred->name = strtolower($name);
                    $ingred->save();
                    //voglio inserire in un vettore con chiave id della ricetta i suoi rispettivi ingredienti
                    //$array_id_ric[0] contiente l id della ricetta corrente
                    //$ingred->id e l ingrediente da aggiungere
                    //sono n per ricetta

                    array_push($vett_id_ing, $ingred->id);

                }else
                {
                    array_push($vett_id_ing, $find[0]->id);
                }

            }

            // dd($vett_id_ing) da gli ingredienti di una sola ricetta
            if($vett_id_ing != null)
                return $vett_id_ing;
        }
    }

    function quantita_ingredienti($html_ricerca, $ingredienti)
    {
        $vett_quantita = array();
        $crawler = Goutte::request('GET', $html_ricerca);
        $vett_quantita = $crawler->filter('.format .recepy .right-push .intro .ingredienti .fs .ingredient')->each(function ($quantita){
            $quantita_str = $quantita->text();
            $quantita_str = preg_replace("/\t/", '', $quantita_str);
            $quantita_str = preg_replace("/\n/", '', $quantita_str);
            $quantita_str = str_replace('Scopri i segreti peruna pasta perfetta', '', $quantita_str);
            $quantita_str = trim($quantita_str);
            return $quantita_str;
        });
        if($vett_quantita != null){
            $index = 0;
            foreach ($ingredienti as $rimuovi){
                $vett_quantita[$index] = str_replace( $rimuovi , '', $vett_quantita[$index]);
                $index += 1;
            };
            return $vett_quantita;
        }

    }

/*
 $link = $crawler->selectLink('Security Advisories')->link();
$crawler = $client->click($link);
  */