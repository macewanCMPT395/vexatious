<?php

class UsersController extends BaseController {
	public $user;
	public $layout = 'layouts.header';

	public function __construct(User $user) 
	{
		$this->user = $user;
	}
	
    public function index() 
    {
        $users = User::all();
        return $layout->nest('content','users.index');
    }
    
	public function create() 
    {
		if(Auth::check()) return Redirect::route('/');
        return View::make('users.create');
    }
    
	public function store()
	{
		$input = Input::all();
		if (!$this->user->fill($input)->isValid()) {

			$response = array(
				'status' => 1,
				'errors' => $this->user->messages
			);
			//add code or page to deal with this response
			//return Response::json($response);      
			return Redirect::to("/");
		}
		
		$this->user->save();
        
        return Redirect::to("/users/{$user->username}");
	}  
    
    public function show($username)
    {
		$user = User::whereEmail($username)->first();
        return View::make('users.show', ['user' => $user]);
    }
    
    public function edit($username)
    {
		//Need to check if user is an admin first before they can
		//edit other users
		$user = Auth::user();
		if (!$user || !$user->isAdmin()) return Redirect::back();
		return View::make('users.edit', ['user' => $user]);       
    }
	
    public function update()
    {
		//To update a user, all we need to do is
		//update their role. They can insert or remove
		//users from the database manually
		
		//once again, make sure the user logged in is the admin
		//before updating
		$user = Auth::user();
		if (!$user || !$user->isAdmin()) return Redirect::back();
		
		//find user based on id (should be specified by the page form
		$updateUser = User::find(Input::get("userID"));
		
		//then update the role and save
		$updateUser->role = Input::get("role");
		$updateuser->save();
		

		return Redirect::back();
    }
}