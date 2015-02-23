<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitSoftwareRelationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kitSoftware', function(Blueprint $table) {
			$table->bigInteger('kitID');
			$table->foreign('kitID')->references('id')->on('kit');
			
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
		Schema::drop('kitSoftware');
	}

}
