<?php
/*
Contains information for a given branch
*/
	
	
class Branch extends Eloquent {
	protected $table = 'branch';
	public $timestamps = false;
	
	protected $fillable = array(
		'identifier', 'name', 'location'
	);
	
}
