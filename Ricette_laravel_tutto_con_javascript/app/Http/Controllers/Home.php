<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;

class Home extends Controller
{
    public function getingredients(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.welcome', [
            'ingredientifromdb' => $item_ingredienti]);
    }

    public function getrecipes(){
        $item_ingredienti = Ingredient::all();
        return view('pag_recipes.welcome', [
            'ingredientifromdb' => $item_ingredienti]);
    }

    public function print_results(){
        $id_ingredients = $_POST['id_recipes'];

        return view('pag_recipes.results', ['id_ingredients_finded' => $id_ingredients]);
    }

}