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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    
    Route::resource('actualite', 'ActualiteController');    
    Route::resource('user', 'UserController');
    Route::resource('jeu', 'JeuController');
    Route::get('patate', 'HomeController@index');
    Route::get('/me', 'UserController@myAccount')->name('user.myAccount');
    Route::put('/me/{id}', 'UserController@myAccountPut')->name('user.myAccountPut');
    Route::resource('typejeu', 'TypeJeuController');
});


Auth::routes();


