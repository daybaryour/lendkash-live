<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoanEmisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loan_emis', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('request_id')->index('request_id');
			$table->dateTime('emi_date');
			$table->float('amount', 10);
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
		Schema::drop('loan_emis');
	}

}
