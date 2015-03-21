<?php
/*
Booking information
*/

class Booking extends Eloquent {
	protected $table = 'booking';
	public $timestamps = false;
	
	protected $fillable = array(
		'eventName', 'start', 'end', 'shipping', 
		'destination', 'received', 'shipped'
	);
	
}

