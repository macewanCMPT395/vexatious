<?php
/*
This is a predetermined list of Hardware Types.
Each hardware entry will be associated with a type that contains
the name of the hardware and a brief description.
*/
class HardwareType extends Eloquent {
	protected $table = 'hardwareType';
	public $timestamps = false;
	
	protected $fillable = array('name', 'description');
	
}
