<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->foreign('request_id', 'ratings_ibfk_1')->references('id')->on('loan_requests')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('from_id', 'ratings_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('to_id', 'ratings_ibfk_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->dropForeign('ratings_ibfk_1');
			$table->dropForeign('ratings_ibfk_2');
			$table->dropForeign('ratings_ibfk_3');
		});
	}

}
