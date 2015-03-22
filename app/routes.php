<?php
//Legacy
Route::get('/overview', 'PagesController@overview');

Route::get('/home', 'PagesController@home');
Route::get('/signIn', 'PagesController@signIn');
Route::get('/', 'PagesController@signIn');
Route::get('/test', ['uses'=>'PagesController@home', 'as'=> 'home']);
Route::get('/reportdamage', ['uses'=>'PagesController@showReportDamage', 'as'=> 'reportdamage']);
Route::get('/browsekits', ['uses'=>'PagesController@browsekits', 'as'=> 'browsekits']);
Route::get('/bookkit', ['uses'=>'PagesController@bookkit', 'as'=> 'bookkit']);
Route::get('/shipping', ['uses'=>'PagesController@shipping', 'as'=> 'shipping']);

Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::resource('kits','KitController');

