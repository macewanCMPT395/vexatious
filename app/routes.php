<?php
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::resource('kits','KitController');
Route::resource('bookings', 'BookingController');

Route::get('/bookkit', ['uses'=>'PagesController@bookkit', 'as'=> 'bookkit']);
Route::get('/shipping', ['uses'=>'PagesController@shipping', 'as'=> 'shipping']);
Route::get('/', 'PagesController@signIn');
Route::get('/{email}', ['as' => 'home','uses' => 'PagesController@home']);
