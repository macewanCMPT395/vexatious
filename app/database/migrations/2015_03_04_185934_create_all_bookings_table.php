<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('allBookings', function(Blueprint $table) {
			$table->bigInteger('bookingID');
			$table->foreign('bookingID')->references('id')->on('booking');
			
			
			$table->bigInteger('userID');
			$table->foreign('userID')->references('id')->on('users');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('allBookings');
	}

}
