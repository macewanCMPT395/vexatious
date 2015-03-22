<?php
/*
Keeps track of what notification messages need to be generated and sent out.
Each notification entry refers to a user, their booking, and what message needs
to be sent.

To check if a notification needs to be sent out, it can be joined
with the booking table so dates can be checked.
*/
	
	
class UserNotifications extends Eloquent {
	protected $table = 'notifications';
	public $timestamps = false;
	
	protected $fillable = array(
		'userID', 'bookingID', 'msgID'
	);	
}
