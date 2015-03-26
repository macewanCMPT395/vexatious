<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hardware', function(Blueprint $table){
			$table->increments('id');
			
			$table->bigInteger('hardwareTypeID');
			$table->foreign('hardwareTypeID')->references('id')->on('hardwareType');
			
			$table->string('assetTag');
			$table->string('damaged')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hardware');
	}

}
