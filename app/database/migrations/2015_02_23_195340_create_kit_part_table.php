<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitPartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kitParts', function(Blueprint $table){
			$table->increments('id');
			$table->bigInteger('kitID');
			$table->foreign('kitID')->references('id')->on('kit');
			$table->bigInteger('statusID');
			$table->foreign('statusID')->references('id')->on('partStatus');
			$table->string('name');
		});
			
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kitParts');
		//
	}

}
