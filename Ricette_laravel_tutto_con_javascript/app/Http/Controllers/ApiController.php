<?php
namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Goutte;
use Illuminate\Validation\Rules\In;

class ApiController extends Controller
{
    public function getRecipes($number = null){

        if($number != null){
            $recipes = Recipe::orderBy('created_at','desc')->take($number)->get();
        }else{
            $recipes = Recipe::all();
        }
        return response()->json([
            'status' => 'ok',
            'recipes' => $recipes]);
    }

    public function getIngredients(){
        $ingredients = Ingredient::all();
        //costruisce un object formato json
        return response()->json([
            'status' => 'ok',
            'ingredient' => $ingredients]);
    }

    public function get_ingredients_id(Request $request){
        //ids not empty
        $id_ingredients = $_POST['id_ingredients'];
        $vett_id_recipes = $_POST['id_recipes'];
        $vett_query = array();
        if($vett_id_recipes[0] == 0)
            array_splice($vett_id_recipes, 0, 1);
        $recipes=[];
        foreach ($id_ingredients as $id_single_ingredient){
            array_push($recipes,Recipe::whereHas('ingredients', function ($query) use ($id_single_ingredient, $vett_query){
//            foreach ($id_ingredients as $id){
                $query->where('id',$id_single_ingredient);
//            }
                //return $vett_query;
            })->get());

        }
        foreach ($recipes as $id_recipes){
            foreach ($id_recipes as $id_single_recipe) {
                array_push($vett_id_recipes, $id_single_recipe->id);
            }
        }
        return $vett_id_recipes;

        //return $vett_id_recipes;
    }
    /*
    public function getPivot($id = null){
        if($id != null){
            $ricette = new Recipe();
            $pivot = $ricette->ingredients_id($id);

            return response()->json([
                'status' => 'ok',
                'pivot' => $pivot]);
        }
        return response()->json([
            'status' => 'noway',]
        );
    }*/
}