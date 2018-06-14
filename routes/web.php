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

Route::post('manage_crawler', 'Home@crawler')->middleware('rightmenu');

Route::get('/', 'Home@home')->middleware('rightmenu');

Route::get('/index', 'Home@home')->middleware('rightmenu');

Route::post('ingredients_database' , 'Home@ing_db');

Route::post('change_profile', 'Home@change_profile')->middleware('rightmenu');

Route::post('filter' , 'Home@apply_filter')->middleware('rightmenu');

Route::post('/add_research' , 'Home@add_research')->middleware('rightmenu');

Route::post('/trylog' , 'Home@login')->middleware('rightmenu');

Route::post('/trysignup' , 'Home@signup')->middleware('rightmenu');

//DELETE

Route::get('results', function () {
    return view('pag_recipes.results')->middleware('rightmenu');
});

Route::get('all', 'Home@getallrecipes')->middleware('rightmenu');

//Route::get('twopeople', 'Home@fortwopeople');

Route::get('cerca', 'Home@getingredients')->middleware('rightmenu');

Route::post('cerca_ricetta', 'Home@cerca_ricetta')->middleware('rightmenu');

Route::post('lista', 'Home@lista')->middleware('rightmenu');

Route::get('remove/{number}', 'Home@remove')->where('number', '[0-9]+')->middleware('rightmenu');

Route::get('profilo', 'Home@profilo_user')->middleware('rightmenu');

Route::get('logout','Home@logout')->middleware('rightmenu');

Route::get('/{signup}', 'Home@see_auth');

Route::get('/{login}', 'Home@see_auth');

Route::post('give_ingredient' , 'Home@giveingredient')->middleware('rightmenu');

Route::get('ricetta/{number}', 'Home@stamponerecipe')->where('number', '[0-9]+')->middleware('rightmenu');
Route::get('categoria/{value}', 'Home@choose_category')->middleware('rightmenu');




