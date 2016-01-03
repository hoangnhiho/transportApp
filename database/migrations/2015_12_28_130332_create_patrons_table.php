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
			$table->string('picurl')->default('http://i2.wp.com/lh6.googleusercontent.com/-St077kPaI3A/AAAAAAAAAAI/AAAAAAAAAE4/nshp34I8yjM/photo.jpg?w=250');
			$table->string('address');
			$table->string('suburb');
			$table->string('postcode',4);
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
