<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// routes for the main page
Route::get('/', 'HomeController@showWelcome');
Route::get('/home', 'HomeController@showWelcome');

// routes for the score board
Route::get('/scoreboard', 'ScoreBoardController@getScores');
// for ajax call
Route::get('/scoreboard/addscore', 'ScoreBoardController@storeScore');

// routes to play the game
Route::get('/play', 'HomeController@play');