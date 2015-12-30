<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatronsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patrons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('picurl');
			$table->string('address');
			$table->string('suburb');
			$table->string('nearby')->nullable();//patron that is nearby
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patrons');
	}

}
