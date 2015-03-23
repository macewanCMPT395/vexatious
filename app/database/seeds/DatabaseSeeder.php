<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UserTableSeeder');
		$this->call('HardwareTypeTableSeeder');
		$this->call('HardwareTableSeeder');
		$this->call('KitTableSeeder');
		$this->call('NotificationMessageSeeder');
		$this->call('KitHardwareTableSeeder');
		$this->call('BookingSeeder');
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
		
		DB::table('users')->delete();
        User::create(array('email' => 'foo@bar.com', 
						  'branchID' => '1',
						  'password' => 'test',
						  'firstName' => "Bob",
						  'lastName' => "BobbingTon",
						  'role' => User::ADMIN_ROLE 
						  ));
		
		//non-admin user
        User::create(array('email' => 'bar@foo.com', 
						  'branchID' => '1',
						  'password' => 'test',
						  'firstName' => "foobar",
						  'lastName' => "barfoo",
						  'role' => 0 
						  ));
    }

}


class HardwareTypeTableSeeder extends Seeder {
	
	public function run() 
	{
		DB::table('hardwareType')->delete();
		
		HardwareType::create(array(
			"name" => "iPad",
			"description" => "A touch screen device that does magic!"
		));
		
		HardwareType::create(array(
			"name" => "Xbox 360",
			"description" => "360 degrees of nothingness."
		));

		HardwareType::create(array(
			"name" => "Playstation 3",
			"description" => "Sony's 3rd source of grief."
		));
		
		HardwareType::create(array(
			"name" => "Arduinos",
			"description" => "Stuff"
		));
		
		HardwareType::create(array(
			"name" => "Rasperry Pi",
			"description" => "3.14159Something"
		));
		
		HardwareType::create(array(
			"name" => "Macbook",
			"description" => "360 degrees of nothingness."
		));
	}
}


class HardwareTableSeeder extends Seeder {
	
	public function run() 
	{
		DB::table('hardware')->delete();

		
		Hardware::create(array(
			"hardwareTypeID" => 1,
			"assetTag" => "123456",
			"damaged" => "Has a sticky button"
		));
		
		
	}
}

class KitTableSeeder extends Seeder {
	
	public function run()
	{
		DB::table('kit')->delete();
		
		Kit::create(array(
			"type" => 1,
			"currentBranchID" => 1,
			"barcode" => "1234567890123456",
			"description" => "A test kit with one something"
		));
	}
}

class KitHardwareTableSeeder extends Seeder {
	public function run()
	{
		DB::table('kithardware')->delete();
		
		KitHardware::create(array(
			"kitID" => 1,
			"hardwareID" => 1
			
		));
					
	}
}

class NotificationMessageSeeder extends Seeder {
	
	public function run()
	{
		DB::table('notificationMsg')->delete();
		
		//messages can be replaced with whatever
		Messages::create(array(
			"message" => "Have you receieved kit ### yet?"
		));
		
		Messages::create(array(
			"message" => "Have you sent kit ### yet?"
		));
	}
}

class BookingSeeder extends Seeder {
	public function run()
	{
		DB::table('booking')->delete();
		//create the actual booking
		$booking = Booking::create(array(
			"eventName" => "Test Event Number 1",
			"start" => date("d/m/Y", time()),//start time today
			"end"=> date("d/m/Y", time() + (2* 24*60*60)),//end date 2 days from now
			"shipping" => date("d/m/Y", time() + (3* 24*60*60)),
			"destination" => 1,
			"received" => false,
			"shipped" => false,
			"kitID" => 1
		));

		//now link the booking with a user
		DB::table('allBookings')->delete();
		UserBookings::create(array(
			"userID" => 1,
			"bookingID" => $booking->id
		));
		
		//create notifications for the user
		//notifications will need to be joined with the 
		//bookings table to get the proper dates
		DB::table('notifications')->delete();
		//first notification for receiving
		UserNotifications::create(array(
			"userID" => 1,
			"bookingID" => $booking->id,
			"msgID" => 1
		));
		//second notification for shipping
		UserNotifications::create(array(
			"userID" => 1,
			"bookingID" => $booking->id,
			"msgID" => 2
		));	
		
		
		
		//create a second booking
		$booking = Booking::create(array(
			"eventName" => "Test Event Number 2",
			"start" => date("d/m/Y", time()),//start time today
			"end"=> date("d/m/Y", time() + (2* 24*60*60)),//end date 2 days from now
			"shipping" => date("d/m/Y", time() + (3* 24*60*60)),
			"destination" => 1,
			"received" => false,
			"shipped" => false,
			"kitID" => 1
		));

		//now link the booking with a user
		UserBookings::create(array(
			"userID" => 2,
			"bookingID" => $booking->id
		));
		
		//create notifications for the user
		//notifications will need to be joined with the 
		//bookings table to get the proper dates
		//first notification for receiving
		UserNotifications::create(array(
			"userID" => 2,
			"bookingID" => $booking->id,
			"msgID" => 1
		));
		//second notification for shipping
		UserNotifications::create(array(
			"userID" => 2,
			"bookingID" => $booking->id,
			"msgID" => 2
		));	
		
		
		
		
	}
}
		
		
