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

Route::get('/', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);

Route::get('/register', [
    'uses' => 'UserController@getRegister',
    'as' => 'user.register',
    'middleware' => 'guest'
]);

Route::post('/register', [
    'uses' => 'UserController@postRegister',
    'as' => 'user.register',
    'middleware' => 'guest'
]);

Route::get('/login', [
    'uses' => 'UserController@getLogin',
    'as' => 'user.login',
    'middleware' => 'guest'
]);

Route::post('/login', [
    'uses' => 'UserController@postLogin',
    'as' => 'user.login',
    'middleware' => 'guest'
]);

Route::get('/profile', [
    'uses' => 'UserController@getProfile',
    'as' => 'user.profile',
    'middleware' => 'auth'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'user.logout',
    'middleware' => 'auth'
]);

Route::get('/add/product', [
    'uses' => 'ProductController@getAddProduct',
    'as' => 'product.add',
    'middleware' => 'admin'
]);