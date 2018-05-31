<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use App\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use DOMDocument;
use Mockery\Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
class Home extends Controller
{

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
        $item_ingredienti = Ingredient::all();
        if(Session::get('session_user') != null){
            $script = "$('#headerloggedpeople').removeClass('hidden'); ";
            $script .= "$('#header').hide();";
            return $this->index($script);
        }else{
            return response()->view('pag_recipes.index', ['ingredientifromdb' => $item_ingredienti]);
        }
    }

    public function index($script){
        $item_ingredienti = Ingredient::all();
        return response()->view('pag_recipes.index', [
                'ingredientifromdb' => $item_ingredienti, 'script' => $script]
        );
    }

    public function index_ingredients_auth($script, $id_cookie){
        $item_ingredienti = Ingredient::all();
        Session::put('session_user', $id_cookie);
        return response()->view('pag_recipes.index', [
            'ingredientifromdb' => $item_ingredienti, 'script' => $script]
        );
    }

    public function getrecipes(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.index', [
            'ingredientifromdb' => $item_ingredienti]);
    }
    public function add_research(){
//        $ingredient = request('ingredienti');
        dd(request()->all());
    }

    public function getallrecipes(){
        $ricette = Recipe::all();
        $ricette = $ricette->toArray();
        return response()->view('pag_recipes.all',['ricette' => $ricette]);
    }

    public function fortwopeople(){
        $myfile = fopen("../resources/views/pag_recipes/recipesfortwo.blade.php", "r+")or die("Unable to open file!");
        ftruncate($myfile, 122);
        $ricette = Recipe::where('doses_per_person','=', '2 persone')->orWhere('doses_per_person','=', '2 pezzi')->get();

        while(!feof($myfile)) {
            $riga = fgets($myfile);
            if(strpos($riga, '<div id=') > 0){

                foreach ($ricette as $ricetta){
                    $div_results = '<h1><a href="/singlerecipe/'.$ricetta['id'].'">'.'<u>'.Recipe::find($ricetta['id'])->name_recipe.'</u>'.'</a></h1>'.
                        '<img src="'.Recipe::find($ricetta['id'])->recipe_img. '" alt="'.Recipe::find($ricetta['id'])->name_recipe.'">'.
                        '<li> difficolta: '.Recipe::find($ricetta['id'])->difficulty.'</li>'.
                        '<li> dosi: '.Recipe::find($ricetta['id'])->doses_per_person.'</li>'.
                        '<li> tempo di cottura: '.Recipe::find($ricetta['id'])->cooking_time.'</li>'.
                        '<li> tempo di preparazione: '.Recipe::find($ricetta['id'])->preparation_time.'</li>'.
                        ' </br> </br>'
                    ;

                    fwrite($myfile, $div_results);
                }

            }
        }
        fwrite($myfile, '</div>@endsection');
        fclose($myfile);
        return view('/pag_recipes.recipesfortwo');
    }

    public function getrandomrecipes(){
        $vett_recipe = array();
        if(Recipe::count() <= 5){
            if(Recipe::count() == 0){
                $create = '<p>Non ci sono ricette nel database</p>';
                return view('pag_recipes.rightmenu', ['rightmenu' => $create]);
            }
        }else{
            for ($i = 0; $i < 5; $i++){
                array_push($vett_recipe, Recipe::find(rand(1 , Recipe::count())));
            }
            return response()->view('pag_recipes.rightmenu',['ricette_random' => $vett_recipe]);
//            foreach ($vett_recipe as $recipe){
//                dd($recipe->name_recipe);
//                $create .='<a href="/singlerecipe/'.$random_number.'">'.
//                    '<u>'.Recipe::find($random_number)->name_recipe.'</u>'.
//                    '<img style="width: 100%;" src="'.Recipe::find($random_number)->recipe_img.'"></a>'.
//                    ' </br> </br>'
//                ;
//            }
//            $create .= '</div></section>';
        }


        //oppure passale alla view (non ancora testato)
        //cookie non dimentica valore piuttosto cambiare timeexpire


//        $rightmenu = "@include('pag_recipes.rightmenu')";
//        return view('master');
    }

    public function stamponerecipe($number = null){
        if($number != null){

            $myfile = fopen("../resources/views/pag_recipes/singlerecipe.blade.php", "r+")or die("Unable to open file!");
            ftruncate($myfile, 114);
                while(!feof($myfile)) {
                    $riga = fgets($myfile);
                    if(strpos($riga, '<div id=') > 0){
                        $div_results = '<div id="single_top"><h1>'.Recipe::find($number)->name_recipe.'</h1>'.
                            '<img src="'.Recipe::find($number)->recipe_img. '" alt="'.Recipe::find($number)->name_recipe.'">'.
                            '<ul ><li> difficolta: '.Recipe::find($number)->difficulty.'</li>'.
                            '<li> dosi: '.Recipe::find($number)->doses_per_person.'</li>'.
                            '<li> tempo di cottura: '.Recipe::find($number)->cooking_time.'</li>'.
                            '<li> tempo di preparazione: '.Recipe::find($number)->preparation_time.'</li> </ul>'.
                            '</div><div id="single_recipe"><h3> Preparazione: </h3>'.
                            '<p>'.Recipe::find($number)->description.'</p></div>'.
                            ' </br> </br>'
                        ;
                        fwrite($myfile, $div_results);
                    }
                }
                fwrite($myfile, '</div>@endsection');
            fclose($myfile);

            return view('/pag_recipes.singlerecipe');
        }
    }

    public function giveingredient(){
        $vett_ids_ingredients = array();
        $ingredients_gave = $_POST['ingredients'];
        $item_ingredienti = Ingredient::all();
        foreach($item_ingredienti as $ingredient_table) {
            foreach ($ingredients_gave as $single_ingredient_gave){
                if($single_ingredient_gave == $ingredient_table['name']){
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
        $myfile = fopen("../resources/views/pag_recipes/results.blade.php", "r+")or die("Unable to open file!");
        ftruncate($myfile, 117);
        while(!feof($myfile)) {
            $riga = fgets($myfile);
            if(strpos($riga, '<div id=') > 0){
                foreach ($vett_ids_recipes_finded as $result){
                    $div_results = '<img id="risultato" src="'.Recipe::find($result)->recipe_img.'" alt="'.Recipe::find($result)->name_recipe.'">'.
                        '<h1><a href="singlerecipe/'.$result.'"><u>'.Recipe::find($result)->name_recipe.'</u>'.'</a></h1>'.
                        '<li> difficolta: '.Recipe::find($result)->difficulty.
                        '<li> dosi: '.Recipe::find($result)->doses_per_person.'</li>'.
                        '<li> tempo di cottura: '.Recipe::find($result)->cooking_time.'</li>'.
                        '<li> tempo di preparazione: '.Recipe::find($result)->preparation_time.'</li>'.
                        '</br>'
                    ;

                    fwrite($myfile, $div_results);
                }
            }
        }

        fwrite($myfile, '</div>@endsection');
        fclose($myfile);

        return view('/pag_recipes.results');
    }

    public function signup(){
        if(Session::get('session_user') != null){
            $script = "$('#headerloggedpeople').removeClass('hidden'); ";
            $script .= "$('#header').hide();";
            return $this->index($script);
        }else
        {
            $nome = request('nome');
            $cognome = request('cognome');
            $email = request('email');
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
                $new_pw = md5($pw);
                $check_auth = User::where('email', $email)->get();
                if($check_auth->isEmpty()) {
                    $user = new User();
                    $user->name = strtolower($nome);
                    $user->surname = strtolower($cognome);
                    $user->email = strtolower($email);
                    $user->password = strtolower($new_pw);
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
            }
        }
        $email = request('email');
        $pw = request('pw');
        if($email == "" | $pw == "")
        {
            $script = "$('#email').addClass('needs-validation');";
            $script .= "$('#pw').addClass('needs-validation');";
            return response()->view('/pag_recipes.login', ['script' => $script]);
        }
        $new_pw = md5($pw);
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

    public function profilo_user(){
        dd('ff');
    }
}

