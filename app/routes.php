<?php

Route::get('/', 'PagesController@home');
Route::get('/signIn', 'PagesController@signIn');
Route::post('/validate', array('as' => 'users.validate', 'uses' => 'UsersController@validate'));
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::get('/reportdamage', ['as' => 'reportdamage', function(){return View::make('reportdamage');}]);
Route::get('/browsekits', ['as' => 'browsekits', function(){ return View::make('browsekits');}]);