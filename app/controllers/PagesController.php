<?php

class PagesController extends BaseController {
	
    public function __construct()
    {
        $this->beforeFilter('auth');
    }
	
	public function home()
	{
        //Get all bookings
        $bookings = DB::table('booking')->get();
        
        //Pass bookings to view
		return View::make('home' ,compact('bookings'));
	}
    
	public function showReportDamage()
	{
		return View::make('reportdamage');
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


