<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareSoftwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hardwareSoftware', function(Blueprint $table) {
			$table->bigInteger('hardwareID');
			$table->foreign('hardwareID')->references('id')->on('hardware');
			
			$table->bigInteger('softwareID');
			$table->foreign('softwareID')->references('id')->on('software');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hardwareSoftware');
	}

}
