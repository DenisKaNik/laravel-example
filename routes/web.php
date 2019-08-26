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

Route::group(['prefix' => '/'], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/anketa-{litera}', 'AnketaController@index')
        ->where('litera', 'a|b')
        ->name('anketa');

    Route::post('/anketa-{litera}', 'AnketaController@post')
        ->where('litera', 'a|b');
});

// Admin panel
Route::group(['prefix' => '/admin', 'middleware' => ['auth']], function () {
    require __DIR__ . '/admin.php';
});

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});
