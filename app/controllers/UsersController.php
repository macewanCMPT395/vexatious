<?php

class UsersController extends BaseController {
	public $user;
	public $layout = 'layouts.header';

	public function __construct(User $user) 
	{
		$this->user = $user;
        $this->beforeFilter('auth');

	}
	
    public function index() 
    {		
	//if (!Auth::check() || !Auth::user()->isAdmin()) return Redirect::back();
	return View::make('users.index');
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
		//if (!$user || !$user->isAdmin()) return Redirect::back();
		return View::make('users.index', ['user' => $user]);       
    }
	
    public function update($id)
    {
		//To update a user, all we need to do is
		//update their role. They can insert or remove
		//users from the database manually
		
		//once again, make sure the user logged in is the admin
		//before updating
		$user = Auth::user();
		//if (!$user || !$user->isAdmin()) return Redirect::back();
		
		$changeUser = User::find($id);
		if ($changeUser->role == 1) {
		   $changeUser->role = 0;
		} else {
		   $changeUser->role = 1;
		}
		$changeUser->save();
		return Redirect::back();
    }
}