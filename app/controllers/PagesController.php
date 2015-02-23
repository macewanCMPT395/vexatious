<?php

class PagesController extends BaseController {

	

	public function home()
	{
		return View::make('home');
	}
    
    public function signIn()
	{
		return View::make('signIn');
	}
    
    public function calendar()
    {
        Return View::make('calendar');
    }
    
    
    
}


