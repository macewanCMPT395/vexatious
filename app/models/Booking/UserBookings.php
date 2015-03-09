<? php
/*
Keeps track of all bookings created by every user. When a booking is created, 
UserNotifications should be created as well.
*/
	
	
class UserBookings extends Eloquent {
	protected $table = 'allBookings';
	public $timestamps = false;
	
	protected $fillable = array(
		'userID', 'bookingID', 'kitID'
	);	
}
