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
		$this->call('BranchSeeder');
		$this->call('UserTableSeeder');
		$this->call('HardwareTypeTableSeeder');
		$this->call('HardwareTableSeeder');
		$this->call('KitTableSeeder');
		$this->call('KitHardwareTableSeeder');
		$this->call('BookingSeeder');
		
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
		
	User::create(array('email' => 'janedoe@somemail.com',
						  'branchID' => '2',
						  'password' => 'test',
						  'firstName' => "Jane",
						  'lastName' => "Doe",
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

	User::create(array('email' => 'johndoe@somemail.com',
						  'branchID' => '3',
						  'password' => 'test',
						  'firstName' => "John",
						  'lastName' => "Doe",
						  'role' => 0
						  ));

	User::create(array('email' => 'jjohn@somemail.com',
						  'branchID' => '5',
						  'password' => 'test',
						  'firstName' => "Jim",
						  'lastName' => "John",
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
			"name" => "Raspberry Pi",
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
		Hardware::create(array(
			"hardwareTypeID" => 1,
			"assetTag" => "789101",
			"damaged" => "Cracked screen"
		));	
		Hardware::create(array(
			"hardwareTypeID" => 1,
			"assetTag" => "454012",
			"damaged" => null
		));	
		Hardware::create(array(
			"hardwareTypeID" => 2,
			"assetTag" => "103616",
			"damaged" => null
		));	

		Hardware::create(array(
			"hardwareTypeID" => 2,
			"assetTag" => "103617",
			"damaged" => null
		));	

		Hardware::create(array(
			"hardwareTypeID" => 3,
			"assetTag" => "421555",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 3,
			"assetTag" => "421559",
			"damaged" => "Broken WiFi adapter"
		));

		Hardware::create(array(
			"hardwareTypeID" => 4,
			"assetTag" => "634702",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 4,
			"assetTag" => "617369",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 4,
			"assetTag" => "636772",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 5,
			"assetTag" => "819918",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 5,
			"assetTag" => "819567",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 5,
			"assetTag" => "098714",
			"damaged" => "Bent GPIO pins"
		));

		Hardware::create(array(
			"hardwareTypeID" => 5,
			"assetTag" => "700204",
			"damaged" => null
		));


		Hardware::create(array(
			"hardwareTypeID" => 6,
			"assetTag" => "314505",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 6,
			"assetTag" => "411107",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 6,
			"assetTag" => "210987",
			"damaged" => null
		));

		//create some hardware that isn't associated with any kits
		Hardware::create(array(
			"hardwareTypeID" => 2,
			"assetTag" => "998372",
			"damaged" => null
		));
		
		Hardware::create(array(
			"hardwareTypeID" => 3,
			"assetTag" => "445532",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 1,
			"assetTag" => "009875",
			"damaged" => null
		));

		Hardware::create(array(
			"hardwareTypeID" => 4,
			"assetTag" => "336548",
			"damaged" => null
		));
	}
}

class KitTableSeeder extends Seeder {
	
	public function run()
	{
		DB::table('kit')->delete();
		$branch = Branch::where('identifier', '=', 'EPLMNA')->first();
		echo ($branch->id);
		
		Kit::create(array(
			"type" => 1,
			"currentBranchID" => $branch->id,
			"barcode" => "3122167890123456",
			"description" => "A test kit with one something"
		));
		
		Kit::create(array(
			"type" => 2,
			"currentBranchID" => $branch->id,
			"barcode" => "312211001001001",
			"description" => "This kit contains 2 xbox360's."
		));
		
		Kit::create(array(
			"type" => 3,
			"currentBranchID" => $branch->id,
			"barcode" => "3122139583749265",
			"description" => "This kit contains 2 ps3's."
		));

		Kit::create(array(
			"type" => 4,
			"currentBranchID" => $branch->id,
			"barcode" => "3122102645373829",
			"description" => "This kit contains 3 arduinos."
		));

		Kit::create(array(
			"type" => 5,
			"currentBranchID" => $branch->id,
			"barcode" => "3122164719390405",
			"description" => "This kit contains 2 raspberry pi's."
		));

		Kit::create(array(
			"type" => 5,
			"currentBranchID" => $branch->id,
			"barcode" => "3122184920472927",
			"description" => "This kit contains 2 raspberry pi's."
		));

		Kit::create(array(
			"type" => 6,
			"currentBranchID" => $branch->id,
			"barcode" => "3122145678655342",
			"description" => "This kit contains 1 macbook."
		));

		Kit::create(array(
			"type" => 6,
			"currentBranchID" => $branch->id,
			"barcode" => "3122184947392739",
			"description" => "This kit contains 1 macbook."
		));

		Kit::create(array(
			"type" => 6,
			"currentBranchID" => $branch->id,
			"barcode" => "3122194727342311",
			"description" => "This kit contains 1 macbook."
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
		KitHardware::create(array(
			"kitID" => 1,
			"hardwareID" => 2
		));	
		KitHardware::create(array(
			"kitID" => 1,
			"hardwareID" => 3
		));

		KitHardware::create(array(
			"kitID" => 2,
			"hardwareID" => 4
		));

		KitHardware::create(array(
			"kitID" => 2,
			"hardwareID" => 4
		));

		KitHardware::create(array(
			"kitID" => 3,
			"hardwareID" => 6
		));

		KitHardware::create(array(
			"kitID" => 3,
			"hardwareID" => 7
		));

		KitHardware::create(array(
			"kitID" => 4,
			"hardwareID" => 8
		));

		KitHardware::create(array(
			"kitID" => 4,
			"hardwareID" => 9
		));

		KitHardware::create(array(
			"kitID" => 4,
			"hardwareID" => 10
		));

		KitHardware::create(array(
			"kitID" => 5,
			"hardwareID" => 11
		));

		KitHardware::create(array(
			"kitID" => 5,
			"hardwareID" => 12
		));

		KitHardware::create(array(
			"kitID" => 6,
			"hardwareID" => 13
		));

		KitHardware::create(array(
			"kitID" => 6,
			"hardwareID" => 14
		));

		KitHardware::create(array(
			"kitID" => 7,
			"hardwareID" => 15
		));

		KitHardware::create(array(
			"kitID" => 8,
			"hardwareID" => 16
		));

		KitHardware::create(array(
			"kitID" => 9,
			"hardwareID" => 17
		));

	}
}


class BookingSeeder extends Seeder {
    
    public function createBooking($eventName, $start, $end, $destination, $kitID, $userID) {
		
		
		//create the actual booking
		$booking = Booking::create(array(
			"eventName" => $eventName,
			"start" => $start + (24*60^60),//start time today
			"end"=> $end,//end date 2 days from now
			"shipping" => $start - (24*60*60),
#			"receiving" => $start,
			"destination" => $destination,
			"received" => false,
			"shipped" => false,
			"kitID" => $kitID
		));

		//now link the booking with a user
		
		$user = UserBookings::create(array(
			"userID" => $userID,
			"bookingID" => $booking->id,
			"creator" => true
		));
    }
	
	public function daysFromNow($days) {
		$today = getdate();
		$today = strtotime($today['mday'].'-'.$today['mon'].'-'.$today['year']);
		return $today + ($days * 24 * 60 * 60);
	}
    
	public function run()
	{
		DB::table('booking')->delete();
        DB::table('allBookings')->delete();
	$this->createBooking("Ipad Event", 1427760000, 1427846400, 5, 1, 1);
	$this->createBooking("Macbook Event", 1427846400, 1428364800, 1, 7, 1);
	$this->createBooking("PS3 Event", 1427846400, 1428364800, 1, 3, 1);
	$this->createBooking("XBOX360 Event", 1428710400, 1428883200, 1, 2, 1);
	$this->createBooking("Arduino Event", 1430956800, 1431129600, 1, 4, 1);
		
		$this->createBooking("Ship out Event", $this->daysFromNow(2), $this->daysFromNow(4), 5, 1, 1);
	/*$this->createBooking("Flappy Bird LAN Party", $this->daysFromNow(2), 
							 	$this->daysFromNow(4), 1, 1, 1);
        $this->createBooking("Flappy Bird LAN Party", $this->daysFromNow(2), 
							 	$this->daysFromNow(3), 1, 1, 1);
		$this->createBooking("Test Event Number 3", $this->daysFromNow(-2), 
							 	$this->daysFromNow(-1), 1, 1, 1);
		
		$this->createBooking("Test Event Number 4", $this->daysFromNow(2), 
							 	$this->daysFromNow(3), 2, 2, 1);		
	*/	
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
			
			$holidays = $branchinfo["HolidayClosures"];
			
			foreach($holidays["HolidayClosure"] as $holiday) {
				Holiday::create(array(
					"date" => $holiday["HolidayDate"]
				));
			}
		}

	}

}



