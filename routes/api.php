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
Route::middleware('cors')->get('/', function(){
   return [
       'success' => true
   ];
});

// auth routes
Route::get('auth/register', 'AuthController@register');


Route::group(['middleware' => ['jwt.auth']], function(){

	// auth check
	Route::get('auth/check', 'AuthController@check');

	// matchmaking routes
	Route::get('matchmaking/register', 'MatchmakingController@register');
	Route::get('matchmaking/cancel', 'MatchMakingController@cancel');

	// game events
	/*Route::post('game/check', 'GameController@check');
	Route::post('game/fold', 'GameController@fold');
	Route::post('game/raise', 'GameController@raise');
	Route::post('game/call', 'GameController@call');*/

});

Route::post('/event/create', 'EventController@create');
