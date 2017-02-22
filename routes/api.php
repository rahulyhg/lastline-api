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
Route::get('/', function(){
   return [
       'success' => true
   ];
});

Route::post('/event/create', 'EventController@create');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
