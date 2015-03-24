<?php

/*
Handles user login and logout.
*/


class SessionsController extends BaseController {

	public function create() {
		if (Auth::check())
			return Redirect::route('bookings.index');
		
		return View::make('signIn');
	}

	public function store() {
		$email = Input::get('email');
		$password = Input::get('password');


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
		return Response::json($response);
	}

	public function destroy () {
		Auth::logout();
		return Redirect::home();
	}
}