<?php

Route::get('/home', 'PagesController@home');
Route::get('/', 'PagesController@signIn');
Route::get('/test',['as' => 'home',function() { return View::make('home');}]);
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::resource('kits','KitController');
Route::get('/reportdamage', ['uses' => 'PagesController@showReportDamage', 'as' => 'reportdamage']);