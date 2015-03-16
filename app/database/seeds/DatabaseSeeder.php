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