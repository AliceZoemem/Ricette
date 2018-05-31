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

//Route::get('user/{script}/{auth}', 'Home@index_ingredients_auth' );

//Route::get('/', function(){
//    return view('pag_recipes.index');
//});
//Route::get('/', 'Home@getingredients');

Route::get('/', function () {
    return view('pag_recipes.homepage');
});

Route::post('ingredients_database' , 'Home@ing_db');

Route::post('give_ingredient' , 'Home@giveingredient');

Route::post('send_results' , 'Home@print_results');

Route::post('/add_research' , 'Home@add_research');

Route::post('/trylog' , 'Home@login');

Route::post('/trysignup' , 'Home@signup');

//Route::post('signup/{number}' , 'Home@signup');


//DELETE


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

Route::get('all', 'Home@getallrecipes');//POST

Route::get('twopeople', 'Home@fortwopeople');

Route::get('index', 'Home@getingredients');

Route::get('profilo', 'Home@profilo_user');
//Route::get('index', function(){
//    return view('pag_recipes.index');
//});

Route::get('signup', function(){
    return view('pag_recipes.signup');
});

Route::get('login', function(){
    return view('pag_recipes.login');
});

Route::get('logout','Home@logout');
Route::get('master2', function(){
    return view('pag_recipes.master2');
});