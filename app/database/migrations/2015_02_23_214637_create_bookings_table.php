<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking', function(Blueprint $table){
			$table->increments('id');
			$table->bigInteger('userId');
			$table->foreign('userId')->references('id')->on('users');
			
			$table->bigInteger('kitId');
			$table->foreign('kitId')->references('id')->on('kit');
			
			$table->bigInteger('destination');
			$table->foreign('destination')->references('id')->on('branch');
			
			$table->string('eventName');
			$table->date('start');
			$table->date('end');
			$table->date('shipping');
			$table->boolean('received');
			$table->boolean('shipped');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bookings');
	}

}
