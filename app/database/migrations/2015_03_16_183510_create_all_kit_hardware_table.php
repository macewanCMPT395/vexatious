<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllKitHardwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kithardware', function(Blueprint $table) {
			$table->bigInteger("kitID");
			$table->foreign('kitID')->references('id')->on('kit');
			
			$table->bigInteger('hardwareID');
			$table->foreign('hardwareID')->references('id')->on('hardware');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kithardware');
	}

}
