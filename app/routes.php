<?php

Route::get('/home', 'PagesController@home');

Route::get('/overview', 'PagesController@overview');


Route::get('/signIn', 'PagesController@signIn');
Route::get('/', 'PagesController@signIn');
//Route::get('/test',['as' => 'home',function() { return View::make('home');}]);
Route::get('/test', ['uses'=>'PagesController@home', 'as'=> 'home']);
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::get('/reportdamage', ['uses'=>'PagesController@showReportDamage', 'as'=> 'reportdamage']);
Route::resource('kits','KitController');

