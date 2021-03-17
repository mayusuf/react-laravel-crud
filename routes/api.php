<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 REST API routes
*/
 
Route::get('movies', 'ApiController@getMovies');
Route::get('movies/{id}', 'ApiController@getMovie');
Route::post('movies', 'ApiController@createMovie');
Route::put('movies/{id}', 'ApiController@updateMovie');
Route::delete('movies/{id}','ApiController@deleteMovie');

Route::get('categories', 'ApiCategory@getCategories');
Route::post('categories', 'ApiCategory@createCategory');