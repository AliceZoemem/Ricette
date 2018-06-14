<?php
    namespace App\Http\Controllers;

    use App\Ingredient;
    use App\Recipe;
    use function foo\func;
    use Illuminate\Support\Facades\DB;
    use Goutte;
    use Illuminate\Validation\Rules\In;

    class Crawler extends Controller
    {
        public function crawler(){
            $vett_cibi = file('cibi_crawler.txt');
            foreach ($vett_cibi as $key => $cibo){
                $vett_cibi[$key] = preg_replace("/[\n]/", '',$cibo);
            }
            $num_ricette_old = Recipe::count();
            $this->crawler_buonissimo($vett_cibi);
            $this->crawler_giallozafferano($vett_cibi);
            $num_ricette_new = Recipe::count();
            $ricette_ottenute = $num_ricette_new - $num_ricette_old;
            echo 'Success for '. $ricette_ottenute  .' new different recipes';
            //calcolo quante ricette nuove ho ottenuto
        }

        function crawler_buonissimo($vett_cibi){
            foreach($vett_cibi as $cibo) {
                $url = 'https://www.buonissimo.org/search/' . $cibo;
                $crawler_ricerche = Goutte::request('GET', $url);
                $crawler_ricerche->filter('.mainContent .container .colSx .listing .content_box .lstStd >li >a')->each(function ($node) use ($cibo) {
                    $link_recipe = $node->attr('href');
                    $prendi_pagina = Goutte::request('GET', $link_recipe);

                    $vett_ingredienti_quantita = array();
                    $prendi_pagina->filter('.colSx .content > article .ingrRicc > ul > li ')->each(function ($node) use (&$vett_ingredienti_quantita){
                        $ingredient = strtolower(substr($node->html(), 0,strpos($node->html(), '<strong>') - 1));
                        $amount = strtolower(substr($node->html(), strpos($node->html(), '<strong>') + 8,strpos($node->html(), '</strong>')-(strpos($node->html(), '<strong>') + 8)));
                        return $vett_ingredienti_quantita[$ingredient] = $amount;
                    });
                    $vett_id_ing = array();
                    foreach ($vett_ingredienti_quantita as $ingrediente => $quantita){
                        $find = Ingredient::where('name', $ingrediente)->get();
                        if($ingrediente == 'ditalini' | $ingrediente == 'maccheroni'){
                            $ingrediente = 'pasta ' .$ingrediente;
                        }
                        if($find->isEmpty()) {
                            $ingred = new Ingredient();
                            $ingred->name = $ingrediente;
                            $ingred->save();
                            $vett_id_ing[$ingred->id] = $quantita;
                        }else
                        {
                            $vett_id_ing[$find[0]->id] = $quantita;
                        }
                    }
                    if($vett_id_ing != null){
                        $this->ricette_buonissimo($prendi_pagina, $vett_ingredienti_quantita, $cibo, $vett_id_ing);
                    }
                    return;
                });
            }
        }

        function ricette_buonissimo($prendi_pagina, $vett_ingredienti_quantita, $cibo, $vett_id_ing){
            $nome_ricetta = $prendi_pagina->filter('.colSx .content > article > h1')->each(function ($node){
                return $nome_ricetta = strtolower(preg_replace("/[\r\n\t]/", '', $node->text()));
            });
            //$nome_ricetta[0] = nome ricetta
            if (!array_key_exists(0,$nome_ricetta))
                $nome_ricetta[0] = '';
            $vett_specifiche = $prendi_pagina->filter('.content >article .dettRicc li')->each(function ($node){
                $result = preg_replace("/[\r\n\t]/", '', $node->text());
                $result = str_replace('DIFFICOLTÀ:', '', $result);
                $result = str_replace('DOSI:', '', $result);
                $result = str_replace('TEMPO:', '', $result);
                if(strpos($result, 'VINO') === false && strpos($result, 'CUCINA') === false && strpos($result, 'COSTO') === false){
                    if(strpos($result, 'di preparazione') === false)
                        return $result;
                    else{
                        $info_preparation_time = substr($result, 0, strpos($result, ' di preparazione'));
                        $info_cooking_time = substr($result, 16 + strpos($result, ' di preparazione'), strpos($result, ' di cottura') - (16 + strpos($result, ' di preparazione')));
                        return($info_preparation_time . ':' .$info_cooking_time);
                    }
                }

            });
            $vett_specifiche = array_filter($vett_specifiche);
            $specifiche = array();
            foreach ($vett_specifiche as $value){
                $value = strtolower($value);
                if(strpos($value, 'min') ===false)
                    array_push($specifiche, $value);
                else{
                    $time = explode(':',$value);
                    array_push($specifiche, $time[0]);
                    array_push($specifiche, $time[1]);
                }
            }
            if(count($specifiche) < 4){
                $specifiche = array_pad($specifiche, 4, '');
                //se mancasse uno dei valori
            }
            //$specifiche[0] = difficolta
            //$specifiche[1] = dosi
            //$specifiche[2] = tempo preparazione
            //$specifiche[3] = tempo cottura
            $link_img = $prendi_pagina->filter('.content >article >a >picture > img')->each(function ($node) {
                return $node->attr('src');
            });
            if (!array_key_exists(0,$link_img))
                $link_img[0] = '';
            //$link_img[0] = immagine ricetta
            $preparazione = $prendi_pagina->filter('.content > article .prepRicc >ol')->each(function ($node) {
                return strtolower(preg_replace("/[\r\n\t]/", '' ,$node->text()));
            });
            //$preparazione[0] = preparazione
            if (!array_key_exists(0,$preparazione))
                $preparazione[0] = '';
            $controlla_inserimento = Recipe::where('difficulty', $specifiche[0])
                ->where('preparation_time', $specifiche[2])
                ->where('cooking_time', $specifiche[3])
                ->where('doses_per_person',$specifiche[1])
                ->where('description', $preparazione[0])
                ->where('recipe_img', $link_img[0])->get();

            if($controlla_inserimento->isEmpty()) {
                $ricetta = new Recipe();
                $ricetta->difficulty = $specifiche[0];
                $ricetta->preparation_time = $specifiche[2];
                $ricetta->cooking_time = $specifiche[3];
                $ricetta->doses_per_person = $specifiche[1];
                $ricetta->name_recipe = $nome_ricetta[0];
                $ricetta->description = $preparazione[0];
                $ricetta->recipe_img = $link_img[0];
                $ricetta->category = $cibo;
                $ricetta->save();
                foreach ($vett_id_ing as $id_ingredient => $amount){
                    $new_array_insert[$id_ingredient]['amount'] = $amount;
                }
                //$new_array_insert[id_ingredient] = amount(fisso) => valore
                $ricetta->ingredients()->attach($new_array_insert);//attach appende al db una riga la sync invece pulisce le righe gia inserite e parte dall inizio
                $ricetta->save();
            }


        }

        function crawler_giallozafferano($vett_cibi){
            foreach($vett_cibi as $cibo) {
                $url = 'http://www.giallozafferano.it/ricerca-ricette/' . $cibo;
                $crawler_ricerche = Goutte::request('GET', $url);
                $crawler_ricerche->filter('.sitewidth .format .loop .flex .title-recipe')->each(function ($node) use ($cibo){
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
                    $array_ingredienti = get_ingredients($html);
                    $array_id_ingredienti = get_id_ingredients($array_ingredienti, $html);
                    ricette_giallozafferano($html, $array_id_ingredienti, $array_ingredienti, $cibo);
                });
            }
            return;
        }
    }


    function ricette_giallozafferano($html_ricerca, $array_id_ingredienti, $array_ingredienti, $cibo)
    {
        $prendi_pagina = Goutte::request('GET', $html_ricerca);
        $ricerca_specifica_requisiti = array('.difficolta', '.preptime', '.cooktime', '.yield');
        $field = array('difficulty', 'preparation_time', 'cooking_time', 'doses_per_person');
        $i = 0;
        foreach ($ricerca_specifica_requisiti as $specifica){
            $filtro_ricerca = '.format .recepy .right-push .intro .jus .rInfos ' .$specifica;
            $requisiti_ottenuti = $prendi_pagina->filter($filtro_ricerca)->each(function ($requisiti_item) {
                $requisiti_str = preg_replace("/[\r\n\t]/", '', $requisiti_item->text());
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
                $vett_requisiti[$field[$i]] = $requisiti_ottenuti[0];
                $i += 1;
                if($i == 4){
                    $name_ric = substr_replace (preparazione($prendi_pagina),0, strpos(preparazione($prendi_pagina), '£'));
                    $vett_requisiti['name_recipe'] = strtolower(str_replace("0" , "", $name_ric));
                    $descrizione = substr_replace (preparazione($prendi_pagina),'', 0, strpos(preparazione($prendi_pagina), '£'));
                    $descrizione = str_replace("£ ", "", $descrizione);
                    $vett_requisiti['description'] = strtolower($descrizione);
                    $vett_requisiti['recipe_img'] = ricetta_img($prendi_pagina);
                    $vett_requisiti['doses_per_person'] = strtolower($vett_requisiti['doses_per_person']);
                    $vett_requisiti['cooking_time'] = strtolower($vett_requisiti['cooking_time']);
                    $vett_requisiti['preparation_time'] = strtolower($vett_requisiti['preparation_time']);
                    $vett_requisiti['difficulty'] = strtolower($vett_requisiti['difficulty']);

                    $controlla_inserimento = Recipe::where('difficulty', $vett_requisiti['difficulty'])
                        ->where('preparation_time', $vett_requisiti['preparation_time'])
                        ->where('cooking_time', $vett_requisiti['cooking_time'])
                        ->where('doses_per_person', $vett_requisiti['doses_per_person'])
                        ->where('description', $vett_requisiti['description'])
                        ->where('recipe_img', $vett_requisiti['recipe_img'])->get();
                    if($controlla_inserimento->isEmpty()){
                        $ricetta = new Recipe();
                        $ricetta->difficulty = $vett_requisiti['difficulty'];
                        $ricetta->preparation_time = $vett_requisiti['preparation_time'];
                        $ricetta->cooking_time = $vett_requisiti['cooking_time'];
                        $ricetta->doses_per_person = $vett_requisiti['doses_per_person'];
                        $ricetta->name_recipe = $vett_requisiti['name_recipe'];
                        $ricetta->description = $vett_requisiti['description'];
                        $ricetta->recipe_img = $vett_requisiti['recipe_img'];
                        $ricetta->category = $cibo;
                        $ricetta->save();

                        $vett_amount = quantita_ingredienti($html_ricerca, $array_ingredienti);
                        $new_array_insert = array();
                        $x = 0;
                        foreach ($array_id_ingredienti as $id_ingredient){
                            $new_array_insert[$id_ingredient]['amount'] = $vett_amount[$x] ;
                            $x += 1;
                        }
                        //$new_array_insert[id_ingredient] = amount(fisso) => valore
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
            $preparazione_str = preg_replace("/[\r\n\t]/", '', $preparazione_str);
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

    function ricetta_img($prendi_pagina){
        $ricetta_img = $prendi_pagina->filter('img')->attr("src");

        if($ricetta_img != null)
            return $ricetta_img;
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
            $vett_quantita = quantita_ingredienti($html_ricerca, $vett_ing);
            foreach ($vett_ing as $name){
                $name = strtolower($name);
                foreach ($tipi_pasta as $pasta){
                    if($name == $pasta){
                        $name = 'pasta ' .$name ;
                    }
                }
                $find = Ingredient::where('name', $name)->get();
                if($find->isEmpty()){
                    $ingred = new Ingredient();
                    $ingred->name = $name;
                    $ingred->save();
                    //voglio inserire in un vettore con chiave id della ricetta i suoi rispettivi ingredienti
                    //$array_id_ric[0] contiente l id della ricetta corrente
                    //$ingred->id e l ingrediente da aggiungere
                    array_push($vett_id_ing, $ingred->id);
                }else
                {
                    array_push($vett_id_ing, $find[0]->id);
                }
            }
            // $vett_id_ing da gli ingredienti di una sola ricetta
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
            $quantita_str = preg_replace("/[\r\n\t]/", '', $quantita_str);
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