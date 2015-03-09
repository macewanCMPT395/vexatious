<?php
/*
This is essentially a list of predefined software
types that can be assigned to software installed
on the devices. It will be handy for browsing later
on.
*/
class SoftwareType extends Eloquent {
	protected $table = 'softwareType';
	public $timestamps = false;
	
	protected $fillable = array('type');
	
}
