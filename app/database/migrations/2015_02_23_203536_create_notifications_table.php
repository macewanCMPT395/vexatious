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
			$table->bigInteger('userId');
			$table->foreign('userId')->references('id')->on('users');
			
			$table->bigInteger('bookingID');
			$table->foreign('bookingID')->references('id')->on('booking');
			
			$table->bigInteger('msgId');
			$table->foreign('msgId')->references('id')->on('notificationMsg');
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
