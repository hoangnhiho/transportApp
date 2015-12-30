<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPatronTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_patron', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned()->index();
			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

			$table->integer('patron_id')->unsigned()->index();
			$table->foreign('patron_id')->references('id')->on('patrons')->onDelete('cascade');

			$table->string('carthere');
			$table->string('carback');
			$table->string('leavingtime');

			$table->boolean('softDelete');
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
		Schema::drop('event_patron');
	}

}
