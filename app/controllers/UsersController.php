<?php

class UsersController extends BaseController {
	protected $user;


	public function __construct(User $user) 
	{
		$this->user = $user;
	}
	
    public function index() 
    {
        $users = User::all();
        return View::make('users.index', ['users' => $users]);
    }
    
	public function create() 
    {
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
		if ($user->role == User::ADMIN_ROLE) 
			return View::make('users.edit', ['user' => $user]);
		
		return Redirect::back();        
    }
	
    public function update()
    {
		//To update a user, all we need to do is
		//update their role. They can insert or remove
		//users from the database manually
		
		//once again, make sure the user logged in is the admin
		//before updating
		$user = Auth::user();
		if ($user->role != User::ADMIN_ROLE)
			return Redirect::back();
		
		//find user based on id (should be specified by the page form
		$updateUser = User::find(Input::get("userID"));
		
		//then update the role and save
		$updateUser->role = Input::get("role");
		$updateuser->save();
		

		return Redirect::back();
    }
}