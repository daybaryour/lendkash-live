<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToLoanEmisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loan_emis', function(Blueprint $table)
		{
			$table->foreign('request_id', 'loan_emis_ibfk_1')->references('id')->on('loan_requests')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loan_emis', function(Blueprint $table)
		{
			$table->dropForeign('loan_emis_ibfk_1');
		});
	}

}
