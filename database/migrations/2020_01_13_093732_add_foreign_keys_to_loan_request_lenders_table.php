<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLoanRequestLendersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loan_request_lenders', function(Blueprint $table)
		{
			$table->foreign('user_id', 'loan_request_lenders_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('request_id', 'loan_request_lenders_ibfk_2')->references('id')->on('loan_requests')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loan_request_lenders', function(Blueprint $table)
		{
			$table->dropForeign('loan_request_lenders_ibfk_1');
			$table->dropForeign('loan_request_lenders_ibfk_2');
		});
	}

}
