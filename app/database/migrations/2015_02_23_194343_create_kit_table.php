<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kit', function(Blueprint $table) {
			$table->increments('id');
			
			$table->bigInteger('hardwareID');
			$table->foreign('hardwareID')->references('id')->on('hardware');
			
			$table->bigInteger('type');
			$table->foreign('type')->references('id')->on('hardwareType');
			
			$table->bigInteger('currentBranchID');
			$table->foreign('currentBranchID')->references('id')->on('branch');
			
			$table->string("description");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kit');
	}

}
