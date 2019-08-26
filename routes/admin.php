<?php

Route::get('/', 'AdminController@index')->name('admin.index');
Route::any('/home', 'Admin\\HomeController@index')->name('admin.home');

Route::get('/anketa', 'Admin\\AnketaController@index')->name('admin.anketa');

Route::any('/anketa-{litera}', 'Admin\\AnketaController@content')
    ->where('litera', 'a|b')
    ->name('admin.anketa-content');

Route::any('/anketa/show', 'Admin\\AnketaController@show')->name('admin.anketa-show');

Route::get('/dashboard', function() {
    return 'Welcome Admin!';
})->name('admin.dashboard');
