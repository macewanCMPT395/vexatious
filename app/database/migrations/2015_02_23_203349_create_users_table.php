<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table){
			$table->increments('id');
			$table->string('remember_token', 100)->nullable();
			$table->bigInteger('branchID');
			$table->foreign('branchID')->references('id')->on('branch');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('firstName');
			$table->string('lastName');
			$table->integer('role');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
