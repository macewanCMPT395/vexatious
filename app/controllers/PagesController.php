<?php

class PagesController extends BaseController {

	

	public function home()
	{
		return View::make('home');
	}
	
	public function showReportDamage()
	{
		return View::make('reportdamage');
	}
    
    public function signIn()
	{
		return View::make('signIn');
	}
    
    public function validate()
    {
        //$user = new User;
        //$user->UserName = Input::get('Username');
        //$user->Password = Hash::make(Input::get('Password'));
        
        //$username = $user->UserName;
        
        Return 1;
    }
    
    
    
}


