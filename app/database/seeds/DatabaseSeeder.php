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
		$this->call('KitHardwareTableSeeder');
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

class BookingSeeder extends Seeder {
	public function run()
	{
		Booking::create(array());
	}
}
		
		
