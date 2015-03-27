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
			$table->string('eventName');
			
			$table->bigInteger('start');
			$table->bigInteger('end');
			$table->bigInteger('receiving');
			$table->bigInteger('shipping');
			
			$table->bigInteger('destination');
			$table->foreign('destination')->references('id')->on('branch');

			$table->boolean('received');
			$table->boolean('shipped');
			
			$table->bigInteger('kitID');
			$table->foreign('kitID')->references('id')->on('kit');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking');
	}

}
