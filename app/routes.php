<?php

Route::get('/home', 'PagesController@home');
Route::get('/signIn', 'PagesController@signIn');
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::get('/reportdamage', 'PagesController@showReportDamage');
Route::get('/browsekits', ['as' => 'browsekits', function(){ return View::make('browsekits');}]);
Route::get('/', ['as' => 'signin',function(){ return View::make('signIn');}]);
