<?php
Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');
Route::resource('hardware', 'HardwareController');
Route::resource('hardwaretype', 'HardwareTypeController');
Route::resource('kits','KitController');
Route::resource('bookings', 'BookingController');
Route::get('/shipping', ['uses'=>'BookingController@shipping', 'as'=> 'shipping']);
Route::get('/receiving', ['uses'=>'BookingController@receiving', 'as'=> 'receiving']);
Route::get('/', ['uses' => 'SessionsController@create', 'as'=>'signIn']);
Route::get('logout', ['uses'=>'SessionsController@destroy', 'as'=> 'logout']);
Route::get('kitavailability/{type}/{start}/{end}', 
		   ['uses' => 'BookingController@kitAvailability', 'as' => 'availability']);
Route::get('checkForKit/{type}/{start}/{end}', 
		   ['uses' => 'BookingController@getKitForDate', 'as' => 'check']);
Route::get('reportDamage',['uses'=>'PagesController@showReportDamage','as'=>'reportdamage']);