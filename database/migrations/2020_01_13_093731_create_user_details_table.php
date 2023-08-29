<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->date('dob')->nullable();
			$table->text('address', 65535)->nullable();
			$table->text('employer_detail', 65535)->nullable();
			$table->integer('country_id')->nullable();
			$table->integer('state_id')->nullable();
			$table->integer('city_id')->nullable();
			$table->enum('status', array('inactive','active'))->default('inactive');
			$table->boolean('is_approved')->default(0);
			$table->boolean('kyc_status')->default(0);
			$table->string('bank_name', 100)->nullable();
			$table->string('bvn', 50)->nullable();
			$table->string('account_holder_name', 100)->nullable();
			$table->integer('account_number')->nullable();
			$table->string('id_proof_document')->nullable();
			$table->string('employment_document')->nullable();
			$table->float('wallet_balance', 10)->default(0.00);
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
		Schema::drop('user_details');
	}

}
