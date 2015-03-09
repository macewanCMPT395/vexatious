<?php




class SessionsController extends BaseController {

	public function create() {
		if (Auth::check()) return Redirect::to('/');
		return View::make('sessions.create');
	}

	public function store() {
		$email = Input::get('email');
		$password = Input::get('password');


		if (Auth::attempt(Input::only('email', 'password'))) {
			//successful authentication
			$response = array(
			 "status" => 0
			);

			return Redirect::home();
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