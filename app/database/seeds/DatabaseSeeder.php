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
		$this->call('BranchSeeder');
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
		
		DB::table('users')->delete();
        User::create(array('email' => 'foo@bar.com', 
						  'branchID' => '5',
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
		
		Kit::create(array(
			"type" => 2,
			"currentBranchID" => 3,
			"barcode" => "1001001001001001",
			"description" => "This kit contains 4 whatevers with their accessories."
		));
		
		Kit::create(array(
			"type" => 3,
			"currentBranchID" => 2,
			"barcode" => "NOTABARCODEWATEV",
			"description" => "This kit contains 7 number 3 combos and a large fries."
		));
		Kit::create(array(
			"type" => 1,
			"currentBranchID" => 2,
			"barcode" => "NEWESTBARCODE",
			"description" => "This kit contains 7 number 3 combos and a large fries."
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
    
    public function createBooking($eventName, $start, $end, $destination, $kitID, $userID) {
		
		DB::table('booking')->delete();
		//create the actual booking
		$booking = Booking::create(array(
			"eventName" => $eventName,
			"start" => $start,//start time today
			"end"=> $end,//end date 2 days from now
			"shipping" => $start - ((1)* 24*60*60),
			"destination" => 1,
			"received" => false,
			"shipped" => false,
			"kitID" => 1
		));

		//now link the booking with a user
		DB::table('allBookings')->delete();
		$user = UserBookings::create(array(
			"userID" => 1,
			"bookingID" => $booking->id
		));
		
		//create notifications for the user
		//notifications will need to be joined with the 
		//bookings table to get the proper dates
		DB::table('notifications')->delete();
		//first notification for receiving
		$not1 = UserNotifications::create(array(
			"userID" => 1,
			"bookingID" => $booking->id,
			"msgID" => 1
		));
        DB::table('notifications')->delete();
		//second notification for shipping
		$not2 = UserNotifications::create(array(
			"userID" => 1,
			"bookingID" => $booking->id,
			"msgID" => 2
		));	
		
    }
    
	public function run()
	{
		$today = getdate();
		$today = strtotime($today['mday'].'-'.$today['mon'].'-'.$today['year']);
        
        $this->createBooking(("Flappy Bird LAN Party"), ($today + (2* 24*60*60)), ($today + ((3)* 24*60*60)), 1, 1, 1);
		//create a third booking
		$booking = Booking::create(array(
			"eventName" => "Test Event Number 3",
			"start" => $today - (2*24*60*60),//start time today
			"end"=> $today - (1* 24*60*60),//end date 2 days from now
			"shipping" => $today - (3* 24*60*60),
			"destination" => 1,
			"received" => true,
			"shipped" => true,
			"kitID" => 1
		));

		//now link the booking with a user
		UserBookings::create(array(
			"userID" => 1,
			"bookingID" => $booking->id
		));
		
		//create notifications for the user
		//notifications will need to be joined with the 
		//bookings table to get the proper dates
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
		
		//create 4th booking
		$booking = Booking::create(array(
			"eventName" => "Test Event Number 4",
			"start" => $today,//start time today
			"end"=> $today + (2* 24*60*60),//end date 2 days from now
			"shipping" => $today + (3* 24*60*60),
			"destination" => 1,
			"received" => false,
			"shipped" => false,
			"kitID" => 4
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
		
class BranchSeeder extends Seeder {

	public function run()
	{

		DB::table('branch')->delete();

		// load the contents of the branches.xml file
		$xml = file_get_contents('app/database/branches.xml');

		// parse the loaded xml file
		$parsed = Parser::xml($xml);

		// get the important information out of the branches.xml
		// file and seed the database with it
		foreach($parsed['BranchInfo'] as $branchinfo) {

			$branchID = $branchinfo['BranchId'];
			$branchName = $branchinfo['Name'];
			$branchAddress = $branchinfo['Address'];
			$branchZip = $branchinfo['ZipCode'];
			$branchLocation = $branchAddress." ".$branchZip;

			Branch::create(array(
				"identifier" => $branchID,
				"name" => $branchName,
				"location" => $branchLocation
			));

		}

	}

}

