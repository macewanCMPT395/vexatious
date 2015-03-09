<?php
/*
	This is an entry for a piece of software.
	There are predefined types of software that
	can be associated with new software. What this does
	is allow a person to add a new software, with a predefined
	type, and provide a name for it.
	
	In the future, one should be able to browser devices based on 
	software type rather than software name specifically.

*/
class Software extends Eloquent {
	protected $table = 'software';
	public $timestamps = false;
	
	protected $fillable = array(
		'softwareTypeID', 'name'
	);
	
}
