<?php

class Holiday extends Eloquent {
	protected $table = 'holidays';
	public $timestamps = false;
	
	protected $fillable = array(
		'date'
	);	
}
