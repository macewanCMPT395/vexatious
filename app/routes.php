<?php

Route::get('/', 'PagesController@signIn');
Route::get('/{email}', ['as' => 'home','uses' => 'PagesController@home']);
Route::get('/signin', 'PagesController@signIn');
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::get('/reportdamage', ['uses'=>'PagesController@showReportDamage', 'as'=> 'reportdamage']);
Route::resource('kits','KitController');

