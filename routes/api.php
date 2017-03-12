<?php

use Illuminate\Http\Request;

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

Route::get('mm', function(){
	Artisan::call('matchmaking:find');
});

Route::middleware('cors')->get('/', function(){
   return [
       'success' => true
   ];
});

// auth routes
Route::middleware('cors')->get('auth/register', 'AuthController@register');


Route::group(['middleware' => ['jwt.auth', 'cors']], function(){

	// auth check
	Route::get('auth/check', 'AuthController@check');

	// matchmaking routes
	Route::get('matchmaking/register', 'MatchMakingController@register');
	Route::get('matchmaking/cancel', 'MatchMakingController@cancel');

	// game events
	Route::get('game/check', 'GameController@check');
	Route::get('game/fold', 'GameController@fold');
	Route::get('game/raise', 'GameController@raise');
	Route::get('game/call', 'GameController@call');

});

Route::post('/event/create', 'EventController@create');
