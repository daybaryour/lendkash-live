<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('request_id')->index('rating_details_ibfk_1');
			$table->integer('from_id')->index('from_id');
			$table->integer('to_id')->index('to_id');
			$table->integer('rating');
			$table->text('reviews', 65535)->nullable();
			$table->boolean('flag')->default(0);
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
		Schema::drop('ratings');
	}

}
