<?php
/*
This represents the physical device to add to the database.
It will be associated with a kit, and software as well.
*/


class Hardware extends Eloquent {
	protected $table = 'hardware';
	public $timestamps = false;
	
	protected $fillable = array('hardwareTypeID','barcode', 'damaged');
	
}
