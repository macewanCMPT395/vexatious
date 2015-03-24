<?php

/*
Handles user login and logout.
*/

use Illuminate\Support\MessageBag;

class SessionsController extends BaseController {


	public function create() {
		if (Auth::check())
			return Redirect::route('bookings.index');
		
		return View::make('signIn');
	}

	public function store() {
		$email = Input::get('email');
		$password = Input::get('password');	
		$errors = new MessageBag;
		if (Auth::attempt(Input::only('email', 'password'))) {
			//successful authentication
			$response = array(
			 "status" => 0
			 );
			return Redirect::route('bookings.index');
		}

		$response = array(
			"status" => 1,
			"error" => "Invalid Username or Password"
		);

		 $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
		 return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
		//return Response::json($response);
	}

	public function destroy () {
		Auth::logout();
		return Redirect::route('signIn');
	}
}