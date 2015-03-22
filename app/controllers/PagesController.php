<?php

class PagesController extends BaseController {

	public function home()
	{
        //Get all bookings
        $bookings = DB::table('booking')->get();
        
        //Pass bookings to view
		return View::make('home' ,compact('bookings'));
	}
    
    public function browsekits()
	{
        //Get all kits
        $kits = DB::table('kit')->get();
        //dd($kits);
        //Pass kits to view
		return View::make('browsekits' ,compact('kits'));
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


