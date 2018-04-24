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
use Illuminate\Database\Eloquent\Model;


Route::get('crawler', 'Crawler@getrecipes');

Route::get('/', 'Home@getingredients');

Route::post('results', 'Home@print_results');
    //'Home@get_ids_research');

Route::get('api/recipes/{number}', 'ApiController@getRecipes');

Route::get('api/recipes', 'ApiController@getRecipes');

Route::get('api/ingredients', 'ApiController@getIngredients');

Route::post('api/pivot', 'ApiController@get_ingredients_id');

Route::get('all', function () {
    return view('pag_recipes.all');
});

Route::get('oneperson', function () {
    return view('pag_recipes.recipesforone');
});

Route::get('1', function () {
    return view('pag_recipes.firstlastrecipe');
});

Route::get('2', function () {
    return view('pag_recipes.secondlastrecipe');
});

Route::get('3', function () {
    return view('pag_recipes.thirdlastrecipe');
});

Route::get('4', function () {
    return view('pag_recipes.fourthlastrecipe');
});

Route::get('5', function () {
    return view('pag_recipes.fifthlastrecipe');
});