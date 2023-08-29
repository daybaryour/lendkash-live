<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoanRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loan_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->integer('loan_interest_rate')->comment('rate in percent');
			$table->integer('loan_term')->comment('monthly term (3, 6, 9, 12)');
			$table->float('loan_request_amount', 10);
			$table->integer('admin_interest_rate')->comment('interest rate of admin at a time request is added');
			$table->text('loan_description', 65535)->nullable();
			$table->enum('loan_status', array('pending','approved','waiting','expired','rejected','cancelled','completed'))->default('pending');
			$table->text('loan_cancelled_reason', 65535)->nullable();
			$table->float('received_amount', 10)->default(0.00);
			$table->string('payment_frequency', 50)->nullable()->comment('Default monthly');
			$table->dateTime('loan_request_date');
			$table->dateTime('request_expiry_date');
			$table->dateTime('loan_start_date')->nullable();
			$table->dateTime('loan_end_date')->nullable();
			$table->float('loan_amount_with_interest', 10)->default(0.00);
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
		Schema::drop('loan_requests');
	}

}
