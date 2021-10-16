<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//my work

Route::namespace('App\Http\Controllers')->group(function(){
    //get api: fetch one or more records
    //without parameter
    Route::get('users', 'APIController@getUsers');

    //with parameter
    Route::get('users/{id?}', 'APIController@getUsers');

    //post api: add single user records
    Route::post('add-user', 'APIController@addUser');

    //post api: add single or multiple users records
    Route::post('add-multiple-users', 'APIController@addMultipleUsers');
});

