<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->bigInteger('userID');
			$table->foreign('userID')->references('id')->on('users');
			
			$table->bigInteger('bookingID');
			$table->foreign('bookingID')->references('id')->on('booking');
			
			$table->bigInteger('msgID');
			$table->foreign('msgID')->references('id')->on('notificationMsg');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
