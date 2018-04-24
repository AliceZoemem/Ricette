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

Route::post('ingredients_database' , 'Home@ing_db');

Route::post('give_ingredient' , 'Home@giveingredient');

Route::post('send_results' , 'Home@print_results');
//public function print_results(){
//    $id_ingredients = $_POST['ids_recipes'];
//    return view('pag_recipes.results', ['id_ingredients_finded' => $id_ingredients]);
//}
Route::get('results', function () {
    return view('pag_recipes.results');
});

Route::get('rightmenu', 'Home@getrandomrecipes');


Route::get('singlerecipe/{number}', 'Home@stamponerecipe');

Route::get('recipe', function () {
    return view('pag_recipes.singlerecipe');
});
/*Route::get('api/ingredients', 'ApiController@getIngredients');

Route::post('api/pivot', 'ApiController@get_ingredients_id');
*/
Route::get('contact', function(){
    return view('pag_recipes.contact');
});

Route::get('all', 'Home@getallrecipes');

Route::get('twopeople', 'Home@fortwopeople');

Route::get('signup', function(){
    return view('pag_recipes.signup');
});

Route::get('login', function(){
    return view('pag_recipes.login');
});

Route::get('logout', function(){
    return view('auth.logout');
});
Route::get('master2', function(){
    return view('pag_recipes.master2');
});
