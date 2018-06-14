<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use App\User;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use DOMDocument;
use Mockery\Exception;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class Home extends Controller
{
    const METHOD = 'aes-256-ctr';

    function encrypt_decrypt( $string, $action) {
        // you may change these values to your own
        $secret_key = 'my_simple_secret_key';
        $secret_iv = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }

    public function ing_db(){
        $ingredienti = Ingredient::all();
        $ingrediente_inserito = $_POST['ingredient'];
        foreach ($ingredienti as $ing){
            if($ing->name == $ingrediente_inserito){
                return 'si';
            }
        }
        return 'no';
    }

    public function getingredients(){
        Session::forget('array_ingredienti');
        $item_ingredienti = Ingredient::all();
        $rightmenu =\Request::get('rightmenu');
        $check_auth = User::where('id', Session::get('session_user'))->get();
        if(Session::get('session_user') != null){
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return $this->index($script);
            }else{
                return response()->view('pag_recipes.index', [
                        'rightmenu' => $rightmenu,
                        'ingredientifromdb' => $item_ingredienti
                    ]);
            }
        }else
            return response()->view('pag_recipes.index', [
                'rightmenu' => $rightmenu,
                'ingredientifromdb' => $item_ingredienti,
                'rightmenu' => $rightmenu
            ]);
    }

    public function home(){
        Session::forget('array_ingredienti');
        $rightmenu =\Request::get('rightmenu');
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return response()->view('pag_recipes.homepage', ['script' => $script, 'rightmenu' => $rightmenu]);
            }else
                return response()->view('pag_recipes.homepage', ['rightmenu' => $rightmenu]);
        }
        return response()->view('pag_recipes.homepage', ['rightmenu' => $rightmenu]);
    }
    public function index($script){
        $rightmenu =\Request::get('rightmenu');
        $item_ingredienti = Ingredient::all();
        Session::forget('array_ingredienti');
        return response()->view('pag_recipes.index', [
            'rightmenu' => $rightmenu,
            'ingredientifromdb' => $item_ingredienti,
            'script' => $script,
            'rightmenu' => $rightmenu
        ]);
    }

    public function index_ingredients_auth($script, $id_cookie){
        $rightmenu =\Request::get('rightmenu');
        $item_ingredienti = Ingredient::all();
        Session::put('session_user', $id_cookie);
        return response()->view('pag_recipes.index', [
            'rightmenu' => $rightmenu,
            'ingredientifromdb' => $item_ingredienti,
            'script' => $script
        ]);
    }

    public function getrecipes(){
        $rightmenu =\Request::get('rightmenu');
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.index', [
            'rightmenu' => $rightmenu,
            'ingredientifromdb' => $item_ingredienti]);
    }

    public function remove($id = null){
        if($id != null) {
            $script = '';
            if(Session::get('session_user') != null){
                $check_auth = User::where('id', Session::get('session_user'))->get();
                if(!$check_auth->isEmpty()) {
                    $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                    $script .= "$('#headerloggedpeople').removeClass('hidden'); ";
                    $script .= "$('#header').hide();";
                    $script .= "$('#profilo').text('" . $lettera . "');";
                }else{
                    Session::forget('session_user');
                }
            }
            $item_ingredienti = Ingredient::all();
            $rightmenu = \Request::get('rightmenu');
            foreach(Session::get('array_ingredienti') as $key => $ing){
                if(substr($ing, 0 , strpos($ing, '#')) == $id){
                    Session::pull('array_ingredienti.'. $key);
                    $script .= '$("#ing'.$id.'").hide();';
                }
            }
            $lista_ricerca = '';
            $attiva_ricerca = '';
            if(Session::get('array_ingredienti') != null){
                $script .= '$("#avvia").hide();';
                foreach (Session::get('array_ingredienti') as $ing){
                    $id = substr($ing, 0, strpos($ing, '#'));
                    $name = substr($ing, strpos($ing, '#') + 1, strlen($ing));
                    $lista_ricerca .= '<li id="ing' . $id . '" class="ingrediente_inserito">' . $name .
                        '<a href="/remove/' . $id . '">' .
                        '<button id="btn' . $id . '" name="ing" class="btn btn-white" type="submit" style="font-size: 13px">x</button>' .
                        '</a>';
                    '</li>';
                }
                $recipes = array();
                foreach (Session::get('array_ingredienti') as $value){
                    $id = substr($value, 0, strpos($value, '#'));
                    array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id){
                        $query->where('id',$id);
                    })->get());

                }
                $vett_ids_ingredients = array();
                foreach($item_ingredienti as $ingredient_table) {
                    foreach (Session::get('array_ingredienti') as $single_ingredient_gave){
                        $name_ingredient = substr($single_ingredient_gave, strpos($single_ingredient_gave, '#')+ 1, strlen($single_ingredient_gave));
                        if($name_ingredient == $ingredient_table['name']){
                            array_push($vett_ids_ingredients, $ingredient_table['id']);
                        }
                    }

                };
                $vett_ids_recipes = array();
                $recipes = array();
                $vett_query = array();
                $vett_ids_recipes_finded = array();
                foreach ($vett_ids_ingredients as $id){
                    array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id, $vett_query){
                        //foreach ($id_ingredients as $id){
                        $query->where('id',$id);
                        //}

                    })->get());
                }
                foreach ($recipes as $single_recipe){
                    foreach ($single_recipe as $id_single_recipe) {
                        array_push($vett_ids_recipes, $id_single_recipe->id);
                    }
                }
                $vett_count_ids = array_count_values($vett_ids_recipes);
                foreach($vett_count_ids as $key => $value){
                    if($value > 1){
                        array_push($vett_ids_recipes_finded, $key);
                    }
                }
                if($vett_ids_recipes_finded == null){
                    foreach($vett_count_ids as $key => $value){
                        array_push($vett_ids_recipes_finded, $key);
                    }

                }
                $attiva_ricerca .= '<button id="btncerca" type="submit"  name="cerca" class="btn btn-warning" style="font-size: 17px" onclick="cerca_ricetta()">CERCA</button>'.
                    '<label id="trovato">Ricette trovate: '. count($vett_ids_recipes_finded) .'</label></p>';
            }
            return view('pag_recipes.index', [
                'script' => $script,
                'rightmenu' => $rightmenu,
                'attiva_ricerca' => $attiva_ricerca,
                'lista_ricerca' => $lista_ricerca,
                'ingredientifromdb' => $item_ingredienti
            ]);
        }
    }

    public function add_research(){
        $script = '';
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script .= "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
            }else{
                Session::forget('session_user');
            }
        }
        $presenza = false;
        $ingrediente = request('ingredienti');
        $rightmenu =\Request::get('rightmenu');
        $item_ingredienti = Ingredient::all();
        $lista_ricerca = '';
        $attiva_ricerca = '';
        $check_ingredient = Ingredient::where('name', $ingrediente)->get();
        if(!$check_ingredient->isEmpty() && $ingrediente != null) {
            if(Session::get('array_ingredienti') == null){
                Session::push('array_ingredienti', $check_ingredient[0]['id'] . '#' . $ingrediente);
            }
            foreach (Session::get('array_ingredienti') as $ing){
                if($check_ingredient[0]['id'] .'#' . $ingrediente == $ing && $presenza != true)
                    $presenza = true;

                $id = substr($ing, 0, strpos($ing, '#'));
                $name = substr($ing, strpos($ing, '#') + 1, strlen($ing));
                $lista_ricerca .= '<li id="ing' . $id . '" class="ingrediente_inserito">' . $name .
                    '<a href="/remove/' . $id . '">' .
                    '<button id="btn' . $id . '" name="ing" class="btn btn-white" type="submit" style="font-size: 13px">x</button>' .
                    '</a>';
                    '</li>';
            }
            if($presenza == false){
                Session::push('array_ingredienti', $check_ingredient[0]['id'] . '#' . $ingrediente);
                $lista_ricerca .= '<li id="ing' . $check_ingredient[0]['id'] . '" class="ingrediente_inserito">' . $ingrediente .
                   '<a href="/remove/' . $check_ingredient[0]['id'] . '">' .
                   '<button id="btn' . $check_ingredient[0]['id'] . '"  name="ing" class="btn btn-white" type="submit" style="font-size: 13px">x</button>' .
                   '</a>';
                   '</li>';
            }
            $vett_ids_ingredients = array();
            foreach($item_ingredienti as $ingredient_table) {
                foreach (Session::get('array_ingredienti') as $single_ingredient_gave){
                    $name_ingredient = substr($single_ingredient_gave, strpos($single_ingredient_gave, '#')+ 1, strlen($single_ingredient_gave));
                    if($name_ingredient == $ingredient_table['name']){
                        array_push($vett_ids_ingredients, $ingredient_table['id']);
                    }
                }

            };
            $vett_ids_recipes = array();
            $recipes = array();
            $vett_query = array();
            $vett_ids_recipes_finded = array();
            //ricette che hanno quell ingrediente
            foreach ($vett_ids_ingredients as $id){
                array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id, $vett_query){
                    //foreach ($id_ingredients as $id){
                    $query->where('id',$id);
                })->get());
            }
            //tutti gli id delle ricette che hanno quell ingrediente
            foreach ($recipes as $single_recipe){
                foreach ($single_recipe as $id_single_recipe) {
                    array_push($vett_ids_recipes, $id_single_recipe->id);
                }
            }

            //conta il numero di occorrenze per ogni ricetta
            $vett_count_ids = array_count_values($vett_ids_recipes);
            //mette in un vettore tutte le ricette trovate con quegli ingredienti
            foreach($vett_count_ids as $key => $value){
                if($value == count($recipes)){
                    array_push($vett_ids_recipes_finded, $key);
                }
            }

            $attiva_ricerca .= '<button id="btncerca" type="submit"  name="cerca" class="btn btn-warning" style="font-size: 17px" >CERCA</button>'.
                '<label id="trovato">Ricette trovate: '. count($vett_ids_recipes_finded) .'</label></p>';
            $script .= '$("#avvia").hide();';

        }else{
            if(Session::get('array_ingredienti') != null) {
                foreach (Session::get('array_ingredienti') as $ing) {
                    $id = substr($ing, 0, strpos($ing, '#'));
                    $name = substr($ing, strpos($ing, '#') + 1, strlen($ing));
                    $lista_ricerca .= '<li id="ing' . $id . '" class="ingrediente_inserito">' . $name .
                        '<a href="/remove/' . $id . '">' .
                        '<button id="btn' . $id . '" name="ing" class="btn btn-white" type="submit" style="font-size: 13px">x</button>' .
                        '</a>';
                    '</li>';
                }
                $vett_ids_ingredients = array();
                foreach ($item_ingredienti as $ingredient_table) {
                    foreach (Session::get('array_ingredienti') as $single_ingredient_gave) {
                        $name_ingredient = substr($single_ingredient_gave, strpos($single_ingredient_gave, '#') + 1, strlen($single_ingredient_gave));
                        if ($name_ingredient == $ingredient_table['name']) {
                            array_push($vett_ids_ingredients, $ingredient_table['id']);
                        }
                    }

                };
                $vett_ids_recipes = array();
                $recipes = array();
                $vett_query = array();
                $vett_ids_recipes_finded = array();
                foreach ($vett_ids_ingredients as $id) {
                    array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id, $vett_query) {
                        $query->where('id', $id);
                    })->get());
                }
                foreach ($recipes as $single_recipe){
                    foreach ($single_recipe as $id_single_recipe) {
                        array_push($vett_ids_recipes, $id_single_recipe->id);
                    }
                }
                $vett_count_ids = array_count_values($vett_ids_recipes);
                foreach ($vett_count_ids as $key => $value) {
                    if ($value == count($recipes)) {
                        array_push($vett_ids_recipes_finded, $key);
                    }
                }
                $attiva_ricerca .= '<button id="btncerca" type="submit"  name="cerca" class="btn btn-warning" style="font-size: 17px" >CERCA</button>' .
                    '<label id="trovato">Ricette trovate: ' . count($vett_ids_recipes_finded) . '</label></p>';
                $script .= '$("#avvia").hide();';
            }else
                return view('pag_recipes.index', ['rightmenu' => $rightmenu,'ingredientifromdb' => $item_ingredienti, 'script' => $script]);
        }
        return view('pag_recipes.index', [
            'script' => $script,
            'rightmenu' => $rightmenu,
            'attiva_ricerca' => $attiva_ricerca,
            'lista_ricerca' => $lista_ricerca,
            'ingredientifromdb' => $item_ingredienti
        ]);
    }

    public function giveingredient(){
        $script = '';
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script .= "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
            }else{
                Session::forget('session_user');
            }
        }
        $script .= "$('#filtri_generici').hide();";
        $script .= "$('#ricerca_generica').hide();";
        $vett_ids_ingredients = array();
        $rightmenu =\Request::get('rightmenu');
        $ingredients_gave = Session::get('array_ingredienti');
        $item_ingredienti = Ingredient::all();
        foreach($item_ingredienti as $ingredient_table) {
            foreach ($ingredients_gave as $single_ingredient_gave){
                $name_ingredient = substr($single_ingredient_gave, strpos($single_ingredient_gave, '#')+ 1, strlen($single_ingredient_gave));
                if($name_ingredient == $ingredient_table['name']){
                    array_push($vett_ids_ingredients, $ingredient_table['id']);
                }
            }

        };
        $vett_ids_recipes = array();
        $recipes = array();
        $vett_query = array();
        $vett_ids_recipes_finded = array();
        foreach ($vett_ids_ingredients as $id){
            array_push($recipes, Recipe::whereHas('ingredients', function ($query) use ($id, $vett_query){
                $query->where('id',$id);
            })->get());
        }

        foreach ($recipes as $single_recipe){
            foreach ($single_recipe as $id_single_recipe) {
                array_push($vett_ids_recipes, $id_single_recipe->id);
            }
        }

        $vett_count_ids = array_count_values($vett_ids_recipes);
        foreach($vett_count_ids as $key => $value){
            if($value == count($recipes)){
                array_push($vett_ids_recipes_finded, Recipe::find($key));
            }
        }
        if(count($vett_ids_recipes_finded) % 3  == 1)
            $script .= '$(".last").width("33%");';
        if(count($vett_ids_recipes_finded) % 3  == 2)
            $script .= '$(".last").width("66%");';
        return view('/pag_recipes.all', [
            'rightmenu' => $rightmenu,
            'script' => $script,
            'ricette' => $vett_ids_recipes_finded,
            'ingredientifromdb' => $item_ingredienti
        ]);
    }

    public function getallrecipes(){
        Session::forget('array_ingredienti');
        $vettore_filtri = array();
        $rightmenu =\Request::get('rightmenu');
        $names = Recipe::distinct()->get(['name_recipe']);
        $difficulties = Recipe::distinct()->get(['difficulty']);
        $preparation_times = Recipe::distinct()->get(['preparation_time']);
        $cooking_times = Recipe::distinct()->get(['cooking_time']);
        $types = Recipe::distinct()->get(['category']);
        $doses = Recipe::distinct()->get(['doses_per_person']);

        $vettore_filtri['names'] = $names->toArray();
        $vettore_filtri['difficulties'] = $difficulties->toArray();
        $vettore_filtri['preparation_times'] = $preparation_times->toArray();
        $vettore_filtri['cooking_times'] = $cooking_times->toArray();
        $vettore_filtri['types'] = $types->toArray();
        $vettore_filtri['doses'] = $doses->toArray();

        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return response()->view('pag_recipes.category',[
                    'rightmenu' => $rightmenu,
                    'ricette' => $types ,
                    'script' => $script, 'filtri' => $vettore_filtri]
                );
            }else{
                Session::forget('session_user');
                return response()->view('pag_recipes.category', ['ricette' => $types,
                    'rightmenu' => $rightmenu,
                    'filtri' => $vettore_filtri
                ]);
            }
        }else {
            return response()->view('pag_recipes.category', ['ricette' => $types,
                'rightmenu' => $rightmenu,
                'filtri' => $vettore_filtri]
            );
        }
    }
    public function cerca_ricetta(){
        $script = '';
        $rightmenu =\Request::get('rightmenu');
        $name_recipe= strtolower(request('ricerca'));
        $get_result = Recipe::where('name_recipe', $name_recipe)->get();
        $names = Recipe::distinct()->get(['name_recipe']);
        $difficulties = Recipe::distinct()->get(['difficulty']);
        $preparation_times = Recipe::distinct()->get(['preparation_time']);
        $cooking_times = Recipe::distinct()->get(['cooking_time']);
        $types = Recipe::distinct()->get(['category']);
        $doses = Recipe::distinct()->get(['doses_per_person']);
        $vettore_filtri['names'] = $names->toArray();
        $vettore_filtri['difficulties'] = $difficulties->toArray();
        $vettore_filtri['preparation_times'] = $preparation_times->toArray();
        $vettore_filtri['cooking_times'] = $cooking_times->toArray();
        $vettore_filtri['types'] = $types->toArray();
        $vettore_filtri['doses'] = $doses->toArray();

        if(count($get_result) % 3  == 1)
            $script .= '$(".last").width("33%");';
        return response()->view('pag_recipes.all', [
                'rightmenu' => $rightmenu,
                'ricette' => $get_result,
                'filtri' => $vettore_filtri,
                'script' => $script
            ]
        );
    }

    public function choose_category($value = null){
        if($value != null){
            $script = '';
            $rightmenu =\Request::get('rightmenu');
            $get_result = Recipe::where('category', $value)->get();
            $names = Recipe::distinct()->get(['name_recipe']);
            $difficulties = Recipe::distinct()->get(['difficulty']);
            $preparation_times = Recipe::distinct()->get(['preparation_time']);
            $cooking_times = Recipe::distinct()->get(['cooking_time']);
            $types = Recipe::distinct()->get(['category']);
            $doses = Recipe::distinct()->get(['doses_per_person']);
            $vettore_filtri['names'] = $names->toArray();
            $vettore_filtri['difficulties'] = $difficulties->toArray();
            $vettore_filtri['preparation_times'] = $preparation_times->toArray();
            $vettore_filtri['cooking_times'] = $cooking_times->toArray();
            $vettore_filtri['types'] = $types->toArray();
            $vettore_filtri['doses'] = $doses->toArray();

            if(count($get_result) % 3  == 1)
                $script .= '$(".last").width("33%");';
            if(count($get_result) % 3  == 2)
                $script .= '$(".last").width("66%");';
            return response()->view('pag_recipes.all', [
                    'rightmenu' => $rightmenu,
                    'ricette' => $get_result,
                    'filtri' => $vettore_filtri,
                    'script' => $script
                ]
            );
        }

    }

    public function apply_filter(){
        $tipo = strtolower(request('tipo'));
        $tempo_cottura = strtolower(request('tempo_cottura'));
        $tempo_preparazione = strtolower(request('tempo_preparazione'));
        $difficolta = strtolower(request('difficolta'));
        $dosi = strtolower(request('dosi_persone'));
        $rightmenu =\Request::get('rightmenu');
        $names = Recipe::distinct()->get(['name_recipe']);
        $difficulties = Recipe::distinct()->get(['difficulty']);
        $preparation_times = Recipe::distinct()->get(['preparation_time']);
        $cooking_times = Recipe::distinct()->get(['cooking_time']);
        $types = Recipe::distinct()->get(['category']);
        $doses = Recipe::distinct()->get(['doses_per_person']);
        $vettore_filtri['names'] = $names->toArray();
        $vettore_filtri['difficulties'] = $difficulties->toArray();
        $vettore_filtri['preparation_times'] = $preparation_times->toArray();
        $vettore_filtri['cooking_times'] = $cooking_times->toArray();
        $vettore_filtri['types'] = $types->toArray();
        $vettore_filtri['doses'] = $doses->toArray();


        $script = '';
        if($tipo != null | $tempo_cottura != null | $tempo_preparazione != null | $difficolta != null | $dosi != null) {
            if($tipo != null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            //tre
            elseif($tipo == null && $difficolta == null && $tempo_preparazione == null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('preparation_time', $tempo_preparazione)->where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura == null && $dosi == null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione == null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione == null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura == null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('preparation_time', $tempo_preparazione)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura == null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->get();
            //due
            elseif($tipo == null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('doses_per_person', $dosi)->get();
            elseif($tipo == null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione == null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('preparation_time', $tempo_preparazione)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('cooking_time', $tempo_cottura)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura == null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->get();
            //uno
            elseif($tipo == null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta == null && $tempo_preparazione != null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione == null && $tempo_cottura != null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('cooking_time', $tempo_cottura)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura == null && $dosi != null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('doses_per_person', $dosi)->get();
            elseif($tipo != null && $difficolta != null && $tempo_preparazione != null && $tempo_cottura != null && $dosi == null)
                $get_result = Recipe::where('category', $tipo)->where('difficulty', $difficolta)->where('preparation_time', $tempo_preparazione)->where('cooking_time', $tempo_cottura)->get();
            //4
            elseif($tipo != null)
                $get_result = Recipe::where('category', $tipo)->get();
            elseif($tempo_preparazione != null)
                $get_result = Recipe::where('preparation_time', $tempo_preparazione)->get();
            elseif($tempo_cottura != null)
                $get_result = Recipe::where('cooking_time', $tempo_cottura)->get();
            elseif($difficolta != null)
                $get_result = Recipe::where('difficulty', $difficolta)->get();
            elseif($dosi != null)
                $get_result = Recipe::where('doses_per_person', $dosi)->get();
        }else
            $get_result = Recipe::orderBy('id', 'desc')->take(30)->get();
        if(count($get_result) % 3  == 1)
            $script .= '$(".last").width("33%");';
        if(count($get_result) % 3 == 2)
            $script .= '$(".last").width("66%");';
        return response()->view('pag_recipes.all', [
                'rightmenu' => $rightmenu,
                'ricette' => $get_result,
                'filtri' => $vettore_filtri,
                'script' => $script
            ]
        );

    }

    public function fortwopeople(){
        $myfile = fopen("../resources/views/pag_recipes/recipesfortwo.blade.php", "r+")or die("Unable to open file!");
        ftruncate($myfile, 122);
        $ricette = Recipe::where('doses_per_person','=', '2 persone')->orWhere('doses_per_person','=', '2 pezzi')->get();

//        while(!feof($myfile)) {
//            $riga = fgets($myfile);
//            if(strpos($riga, '<div id=') > 0){
//
//                foreach ($ricette as $ricetta){
//                    $div_results = '<h1><a href="/singlerecipe/'.$ricetta['id'].'">'.'<u>'.Recipe::find($ricetta['id'])->name_recipe.'</u>'.'</a></h1>'.
//                        '<img src="'.Recipe::find($ricetta['id'])->recipe_img. '" alt="'.Recipe::find($ricetta['id'])->name_recipe.'">'.
//                        '<li> difficolta: '.Recipe::find($ricetta['id'])->difficulty.'</li>'.
//                        '<li> dosi: '.Recipe::find($ricetta['id'])->doses_per_person.'</li>'.
//                        '<li> tempo di cottura: '.Recipe::find($ricetta['id'])->cooking_time.'</li>'.
//                        '<li> tempo di preparazione: '.Recipe::find($ricetta['id'])->preparation_time.'</li>'.
//                        ' </br> </br>'
//                    ;
//
//                }
//
//            }
//        }
        return view('/pag_recipes.recipesfortwo');
    }

    public function stamponerecipe($number = null){
        Session::forget('array_ingredienti');
        if($number != null){
            $rightmenu =\Request::get('rightmenu');
            if(Session::get('session_user') != null){
                $check_auth = User::where('id', Session::get('session_user'))->get();
                if(!$check_auth->isEmpty()) {
                    $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                    $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                    $script .= "$('#header').hide();";
                    $script .= "$('#profilo').text('" . $lettera . "');";
                }else{
                    Session::forget('session_user');
                    $script = "$('#headerloggedpeople').addClass('hidden'); ";
                    $script .= "$('#header').show();";
                }
            }else{
                $script = "$('#headerloggedpeople').addClass('hidden'); ";
                $script .= "$('#header').show();";
            }
            $recipe = Recipe::find($number);
            $pivot = array();
            $name_ingredient = array();
            $amount_ingredient = array();
            foreach (Recipe::find($number)->ingredients as $user) {
               array_push($amount_ingredient, $user->pivot->amount);
               array_push($name_ingredient, Ingredient::find($user->pivot->ingredient_id)->name);
            }
            $pivot['amount'] = $amount_ingredient;
            $pivot['ingredient'] = $name_ingredient;
            return view('/pag_recipes.singlerecipe', [
                'rightmenu' => $rightmenu,
                'ricetta' => $recipe ,
                'pivot' => $pivot,
                'script' => $script
            ]);
        }
    }

    public function signup(){
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return $this->index($script);
            }else{
                Session::forget('session_user');
                return view('/pag_recipes.singup');
            }
        }else{
            $nome = strtolower(request('nome'));
            $cognome = strtolower(request('cognome'));
            $email = strtolower(request('email'));
            $pw = request('pw');
            $conf_pw = request('confpw');
            if($pw != $conf_pw) {
                $script = "$('#pw').addClass('needs-validation');";
                $script .= "$('#confpw').addClass('needs-validation');";
                return view('/pag_recipes.signup', ['script' => $script]);
            }
            if($nome != "" && $cognome != "" && $email != "" && $pw != null)
            {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $script = "$('#email').addClass('needs-validation');";
                    return view('/pag_recipes.signup', ['script' => $script]);
                }
                $new_pw = $this->encrypt_decrypt($pw, 'e');

                $check_auth = User::where('email', $email)->get();
                if($check_auth->isEmpty()) {
                    $user = new User();
                    $user->name = $nome;
                    $user->surname = $cognome;
                    $user->email = $email;
                    $user->password = $new_pw;
                    $user->isAdmin = 0;
                    $user->save();
                    $id_cookie = $user->id;
                    $lettera = strtoupper(substr($nome, 0, 1));
                    $script = "$('#headerloggedpeople').removeClass('hidden');";
                    $script .= "$('#header').hide();";
                    $script .= "alert('registrazione effettuata con successo');";
                    $script .= "$('#profilo').text('". $lettera ."');";
                    return $this->index_ingredients_auth($script, $id_cookie);
                }else{
                    $script = "$('#email').addClass('needs-validation');";
                    $script .= "alert('Email gia in uso');";
                    return view('/pag_recipes.signup', ['script' => $script]);
                }
            }else{
                $script = "$('#nome').addClass('needs-validation');";
                $script .= "$('#cognome').addClass('needs-validation');";
                $script .= "$('#email').addClass('needs-validation');";
                $script .= "$('#pw').addClass('needs-validation');";
                $script .= "$('#confpw').addClass('needs-validation');";
                return view('/pag_recipes.signup', ['script' => $script]);
            }
        }
    }

    public function logout(){
//        $cookie = Cookie::forget('cookie_user');
        Session::forget('session_user');
        $script = "$('#headerloggedpeople').addClass('hidden'); ";
        $script .= "$('#header').show();";
        return $this->index($script);
    }

    public function login(){
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return $this->index($script);
            }else {
                Session::forget('session_user');
                return view('/pag_recipes.login');
            }
        }
        $email = strtolower(request('email'));
        $pw = request('pw');
        if($email == "" | $pw == "")
        {
            $script = "$('#email').addClass('needs-validation');";
            $script .= "$('#pw').addClass('needs-validation');";
            return response()->view('/pag_recipes.login', ['script' => $script]);
        }
        $new_pw = $this->encrypt_decrypt($pw, 'e');

        $check_auth = User::where('email', $email)->where('password', $new_pw)->get();
        if(!$check_auth->isEmpty()) {
            $id_cookie = $check_auth[0]['id'];
            $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
            $script = "$('#headerloggedpeople').removeClass('hidden'); ";
            $script .= "$('#header').hide();";
            $script .= "$('#profilo').text('". $lettera ."');";
            $script .= "alert('login effettuato con successo');";
            return $this->index_ingredients_auth($script, $id_cookie);
        }else{
            $script = "$('#pw').addClass('needs-validation');";
            $script .= "$('#email').addClass('needs-validation');";
            $script .= "alert('Email o password invalide');";
            return view('/pag_recipes.login', ['script' => $script]);
        }

    }

    public function see_auth($page){
        Session::forget('array_ingredienti');
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $rightmenu =\Request::get('rightmenu');
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";
                return view('pag_recipes.homepage', [
                    'script' => $script,
                    'rightmenu' => $rightmenu
                ]);
            }else{
                Session::forget('session_user');
                return  view('pag_recipes.'.$page);
            }
        }else{
            return  view('pag_recipes.'.$page);
        }
    }

    public function change_profile(){
        Session::forget('array_ingredienti');
        $rightmenu =\Request::get('rightmenu');
        if(Session::get('session_user') != null){
            $nome = strtolower(request('nome'));
            $cognome = strtolower(request('cognome'));
            $email = strtolower(request('email'));
            $pw = request('pw');
            $conf_pw = request('conf-pw');
            $check_auth = User::where('id', Session::get('session_user'))->get();
            $information = $check_auth[0];
            $script = "$('#headerloggedpeople').removeClass('hidden'); ";
            $script .= "$('#header').hide();";
            $check_auth = User::where('id', Session::get('session_user'))->get();
            $information = $check_auth[0];
            if($nome != "" | $cognome | "" | $email != "" | $pw != null)
            {
                if($pw != $conf_pw) {
                    $lettera = strtoupper(substr($information['name'], 0, 1));
                    $script .= "$('#profilo').text('". $lettera ."');";
                    $script .= "$('#pw').addClass('needs-validation');";
                    $script .= "$('#conf-pw').addClass('needs-validation');";
                    return view('/pag_recipes.profilo', ['script' => $script,
                        'information' => $information,
                        'rightmenu' => $rightmenu
                    ]);
                }
                if($email != null){
                    $check_email = User::where('email', $email)->get();
                    if(count($check_email) != 0){
                        $lettera = strtoupper(substr($information['name'], 0, 1));
                        $script .= "$('#profilo').text('". $lettera ."');";
                        $script .= "$('#email').addClass('needs-validation');";
                        $script .= "alert('Email gia' in uso');";
                        return view('/pag_recipes.profilo', [
                            'script' => $script,
                            'information' => $information,
                            'rightmenu' => $rightmenu
                        ]);
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $lettera = strtoupper(substr($information['name'], 0, 1));
                        $script .= "$('#profilo').text('". $lettera ."');";
                        $script .= "$('#email').addClass('needs-validation');";
                        return view('/pag_recipes.profilo', [
                            'script' => $script,
                            'information' => $information,
                            'rightmenu' => $rightmenu
                        ]);
                    }
                }
                $new_pw = $this->encrypt_decrypt($pw, 'e');
                if(!$check_auth->isEmpty()) {
                    $user = new User();
                    $lettera = strtoupper(substr($information['name'], 0, 1));
                    if($nome != null) {
                        $lettera = strtoupper(substr($nome, 0, 1));
                        $user->where('id', Session::get('session_user'))->update(['name' => $nome]);
                    }
                    if($cognome != null)
                        $user->where('id', Session::get('session_user'))->update(['surname' => $cognome]);
                    if($email != null)
                        $user->where('id', Session::get('session_user'))->update(['email' => $email]);
                    if($pw != null){
                        if($new_pw != $check_auth[0]['password'])
                            $user->where('id', Session::get('session_user'))->update(['password' => $new_pw]);
                        else{
                            $lettera = strtoupper(substr($information['name'], 0, 1));
                            $script .= "$('#profilo').text('". $lettera ."');";
                            $script .= "$('#pw').addClass('needs-validation');";
                            $script .= "$('#conf-pw').addClass('needs-validation');";
                            $script .= "alert('Usa una password diversa da quella vecchia');";
                            return view('/pag_recipes.profilo', [
                                'script' => $script,
                                'information' => $information,
                                'rightmenu' => $rightmenu
                            ]);
                        }
                    }
                    $check_auth = User::where('id', Session::get('session_user'))->get();
                    $information = $check_auth[0];
                    $script .= "$('#profilo').text('". $lettera ."');";
                    return view('/pag_recipes.profilo', [
                        'script' => $script,
                        'information' => $information,
                        'rightmenu' => $rightmenu
                    ]);
                }else{
                    $lettera = strtoupper(substr($information['name'], 0, 1));
                    $script .= "$('#profilo').text('". $lettera ."');";
                    $script .= "$('#email').addClass('needs-validation');";
                    $script .= "alert('Email gia in uso');";
                    return view('/pag_recipes.profilo', [
                        'script' => $script,
                        'information' => $information,
                        'rightmenu' => $rightmenu
                    ]);
                }
            }else{
                $lettera = strtoupper(substr($information['name'], 0, 1));
                $script .= "$('#profilo').text('". $lettera ."');";
                $script .= "$('#nome').addClass('needs-validation');";
                $script .= "$('#cognome').addClass('needs-validation');";
                $script .= "$('#email').addClass('needs-validation');";
                $script .= "$('#pw').addClass('needs-validation');";
                $script .= "$('#conf-pw').addClass('needs-validation');";
                return view('/pag_recipes.profilo', ['script' => $script,
                    'information' => $information,
                    'rightmenu' => $rightmenu
                ]);
            }
        }else{
            $script = "$('#headerloggedpeople').addClass('hidden'); ";
            $script .= "$('#header').show();";
            return view('pag_recipes.homepage', [
                'script' => $script,
                'rightmenu' => $rightmenu
            ]);
        }


    }

    public function profilo_user(){
        $rightmenu =\Request::get('rightmenu');
        if(Session::get('session_user') != null){
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if(!$check_auth->isEmpty()) {
                $information = $check_auth[0];
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('". $lettera ."');";
                $altro = '';
                if($information->isAdmin == 1){
                    $altro .= '<button id="crawler" class="btn btn-warning" onclick="crawler()">CRAWLER</button>';
                }
                return view('pag_recipes.profilo', [
                    'crawler' => $altro,
                    'script' => $script,
                    'information' => $information,
                    'rightmenu' => $rightmenu
                ]);
            }else{
                Session::forget('session_user');
                $script = "$('#headerloggedpeople').addClass('hidden'); ";
                $script .= "$('#header').show();";
                return view('pag_recipes.homepage', [
                    'script' => $script,
                    'rightmenu' => $rightmenu
                ]);
            }
        }else{
            $script = "$('#headerloggedpeople').addClass('hidden'); ";
            $script .= "$('#header').show();";
            return view('pag_recipes.homepage', [
                'script' => $script,
                'rightmenu' => $rightmenu
            ]);
        }
    }

    public function crawler(){
        $rightmenu =\Request::get('rightmenu');
        if(Session::get('session_user') != null) {
            $check_auth = User::where('id', Session::get('session_user'))->get();
            if (!$check_auth->isEmpty()) {
                $lettera = strtoupper(substr($check_auth[0]['name'], 0, 1));
                $script = "$('#headerloggedpeople').removeClass('hidden'); ";
                $script .= "$('#header').hide();";
                $script .= "$('#profilo').text('" . $lettera . "');";

            }
            $vett_cibi = file('cibi_crawler.txt');
            foreach ($vett_cibi as $key => $cibo){
                $vett_cibi[$key] = preg_replace("/[\n]/", '',$cibo);
            }



            return view('pag_recipes.crawler', [
                'lista_cibi' => $vett_cibi,
                'script' => $script,
                'rightmenu' => $rightmenu
            ]);
        }else{
            return view('pag_recipes.homepage', [
                'rightmenu' => $rightmenu
            ]);
        }

    }

}

