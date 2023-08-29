<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->float('invest_amount', 10, 0);
			$table->integer('invests_term');
			$table->integer('interest_rate')->comment('interest rate at the time of apply for invest');
			$table->float('maturity_amount', 10)->default(0.00)->comment('final amount of invest (FD) on maturity ');
			$table->enum('status', array('pending','approved','rejected','completed','cancelled'))->default('pending');
			$table->dateTime('invest_start_date')->nullable();
			$table->dateTime('invest_end_date')->nullable();
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
		Schema::drop('invests');
	}

}
