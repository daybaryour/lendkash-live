<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoneyRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('money_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('from_id')->index('from_id');
			$table->integer('to_id')->index('to_id');
			$table->float('amount', 10)->default(0.00);
			$table->enum('status', array('unpaid','paid'))->default('unpaid');
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
		Schema::drop('money_requests');
	}

}
