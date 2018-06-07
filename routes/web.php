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

Route::get('crawler', 'Crawler@crawler');
//Route::get('/', function(){
//    return view('pag_recipes.index');
//});
//Route::get('/', 'Home@getingredients');

Route::get('/', 'Home@home')->middleware('rightmenu');

Route::get('/index', 'Home@home')->middleware('rightmenu');

//Route::post('ingredients_database' , 'Home@ing_db');

//Route::post('give_ingredient' , 'Home@giveingredient');

//Route::post('send_results' , 'Home@print_results');

Route::post('change_profile', 'Home@change_profile')->middleware('rightmenu');

Route::post('filter' , 'Home@apply_filter')->middleware('rightmenu');

//Route::post('/add_research' , 'Home@add_research');

Route::post('/trylog' , 'Home@login');

Route::post('/trysignup' , 'Home@signup');


//DELETE


//public function print_results(){
//    $id_ingredients = $_POST['ids_recipes'];
//    return view('pag_recipes.results', ['id_ingredients_finded' => $id_ingredients]);
//}
Route::get('results', function () {
    return view('pag_recipes.results')->middleware('rightmenu');
});

//Route::get('rightmenu', 'Home@getrandomrecipes');

//Route::get('recipe', function () {
//    return view('pag_recipes.singlerecipe');
//});
/*Route::get('api/ingredients', 'ApiController@getIngredients');

Route::post('api/pivot', 'ApiController@get_ingredients_id');
*/
//Route::get('contact', function(){
//    return view('pag_recipes.contact');
//});

Route::get('all', 'Home@getallrecipes')->middleware('rightmenu');

//Route::get('twopeople', 'Home@fortwopeople');

Route::get('cerca', 'Home@getingredients')->middleware('rightmenu');

Route::post('cerca_ricetta', 'Home@cerca_ricetta')->middleware('rightmenu');

Route::get('profilo', 'Home@profilo_user')->middleware('rightmenu');

Route::get('logout','Home@logout')->middleware('rightmenu');

Route::get('/{signup}', 'Home@see_auth');

Route::get('/{login}', 'Home@see_auth');

Route::get('ricetta/{number}', 'Home@stamponerecipe')->where('number', '[0-9]+')->middleware('rightmenu');
Route::get('categoria/{value}', 'Home@choose_category')->middleware('rightmenu');




