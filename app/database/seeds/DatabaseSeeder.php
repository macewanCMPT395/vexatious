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
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
		
		DB::TABLE('users')->delete();
        User::create(array('email' => 'foo@bar.com', 
						  'branchID' => '1',
						  'password' => 'test',
						  'firstName' => "Bob",
						  'lastName' => "BobbingTon",
						  'role' => User::ADMIN_ROLE 
						  ));
    }

}