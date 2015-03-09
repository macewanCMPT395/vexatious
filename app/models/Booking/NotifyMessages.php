<? php
/*
Notification messages are predefined messages in the database,
useless on their own but will be associated with a notification.
*/
	
	
class NotifyMessage extends Eloquent {
	protected $table = 'notificationMsg';
	public $timestamps = false;
	
	protected $fillable = array('message');	
}
