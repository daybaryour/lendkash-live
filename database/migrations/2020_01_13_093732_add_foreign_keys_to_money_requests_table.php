<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMoneyRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('money_requests', function(Blueprint $table)
		{
			$table->foreign('from_id', 'money_requests_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('to_id', 'money_requests_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('money_requests', function(Blueprint $table)
		{
			$table->dropForeign('money_requests_ibfk_1');
			$table->dropForeign('money_requests_ibfk_2');
		});
	}

}
