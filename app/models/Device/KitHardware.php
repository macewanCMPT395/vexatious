<?php
/*
Keeps track of kits and hardwares
*/


class KitHardware extends Eloquent {
	protected $table = 'kithardware';
	public $timestamps = false;
	
	protected $fillable = array(
		'kitID', 'hardwareID'
	);
	
}