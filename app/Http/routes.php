<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::model('map', 'App\Map');

Route::get('/', 'IndexController@index');
Route::resource('map', 'MapController');
Route::post('/map/{map}/action',['as' => 'map.action', 'uses' => 'MapController@action']);
Route::get('/map/{map}/reset',['as' => 'map.reset', 'uses' => 'MapController@reset']);
Route::post('/map/{map}/turn',['as' => 'map.turn', 'uses' => 'MapController@turn']);
Route::get('/map/{map}/over',['as' => 'map.over', 'uses' => 'MapController@over']);