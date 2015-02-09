<?php

class UsersController extends BaseController {
    
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
        $validator = Validator::make(Input::all(), ['username' => 'required','password' => 'required']);

	if (! $validator->fails() || DB::table('users')->where('UserName', Input::get('Username'))->pluck('name'))
	{
	return Redirect::back()->withErrors($validator->messages());
	}
	//Create new user
        $user = new User;
        $user->username = Input::get('Username');
        $user->password = Hash::make(Input::get('Password'));
        $user->Gender = Input::get('Gender');
        $user->SexualOrientation = Input::get('LookingFor');
        $user->FurColor = Input::get('FurColor');
        $user->Type = Input::get('CommitmentLevel');
        $user->Interests = Input::get('Interests');
        $user->Email = Input::get('Email');
        $user->save();

        
        return Redirect::to("/users/{$user->username}");
	}  
    
    public function validate()
    {
        $username = Input::get('Username');
        $password = Input::get('Password');
        if (Auth::attempt(array('username' => $username, 'password' => $password) ))
	{
        return Redirect::to("/users/{$username}");
	}
	return Redirect::to("/");
    }
    
    public function show($username)
    {
        $users = DB::table('users')->get();
        $users = User::all();
        
        $user = User::whereUsername($username)->first();
        
        return View::make('users.show', ['user' => $user]);
    }
    
    public function edit($username)
    {
        $users = DB::table('users')->get();
        $users = User::all();
        
        $user = User::whereUsername($username)->first();
        
        return View::make('users.edit', ['user' => $user]);
    }
    public function update()
    {
	$username = Input::get('username');
	$password = Hash::make(Input::get('password'));
	$gender = Input::get('Gender');
	$sexualorientation = Input::get('SexualOrientation');
	$furcolor = Input::get('FurColor');
	$type = Input::get('Type');
	$interests = Input::get('Interests');
	$email = Input::get('Email');
	DB::table('users')->where('UserName', $username)->update(array('Password' => $password, 'Gender' => $gender, 'SexualOrientation' => $sexualorientation, 'FurColor' => $furcolor, 'Type' => $type, 'Interests' => $interests, 'Email' => $email));
	return Redirect::back();
    }
}