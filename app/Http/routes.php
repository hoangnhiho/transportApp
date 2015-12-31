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

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');

//====    Dev Pages   ====//
Route::get('joel', 'HomeController@joel');
Route::get('moi', 'HomeController@moi');

//==== Fun Test Pages ====//
Route::get('test', function()
{
    return 'Hello World';
});

//==== Serious Stuff! ====//
Route::get('event/{eventID}', 'HomeController@show');
Route::get('getPatronsInEvent/{eventID}', 'HomeController@getPatronsInEvent');
Route::get('toggleEventPatron/{eventID}/{patronID}/{toggleID}', 'HomeController@toggleEventPatron');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
