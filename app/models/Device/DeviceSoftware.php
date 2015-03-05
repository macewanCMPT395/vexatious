<? php
/*
This will keep track of all the devices
and their associated software.
*/
	
	
class DeviceSoftware extends Eloquent {
	protected $table = 'hardwareSoftware';
	public $timestamps = false;
	
	protected $fillable = array(
		'hardwareID', 'softwareID'
	);
	
}
