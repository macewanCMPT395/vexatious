<?php

Route::get('/', 'PagesController@home');


Route::get('/signIn', 'PagesController@signIn');

Route::get('/calendar', ['as' => 'home', function(){
    return View::make('calendar');
}]);


Route::resource('sessions', 'SessionsController');
Route::resource('users', 'UsersController');

