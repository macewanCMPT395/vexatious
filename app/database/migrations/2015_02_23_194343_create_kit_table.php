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
			$table->bigInteger('barcode');
			$table->string('name');
			$table->string('type');
			$table->string('description');
			$table->string('currentBranch');
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
