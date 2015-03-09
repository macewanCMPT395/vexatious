<?php
/*
A kit is essentially a containner that will be associated
with a bunch of devices. One kit can have many devices,
but a device can only exist in a single kit at a time.
*/


class Kit extends Eloquent {
	protected $table = 'kit';
	public $timestamps = false;
	
	protected $fillable = array(
		'hardwareID', 'type', 'currentBranchID', 'barcode', 'description'
	);
	
}
