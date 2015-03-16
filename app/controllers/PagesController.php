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
    
    public function calendar()
    {
        Return View::make('calendar');
    }
    
    public function overview()
    {
        Return View::make('overview');
    }
}


