<?php

Route::get('/', 'PagesController@home');
Route::get('/signIn', 'PagesController@signIn');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::get('/reportdamage', ['as' => 'reportdamage', function(){return View::make('reportdamage');}]);
Route::get('/browsekits', ['as' => 'browsekits', function(){ return View::make('browsekits');}]);
Route::get('/home', ['as' => 'home',function(){ return View::make('home');}]);