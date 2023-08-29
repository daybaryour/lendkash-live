<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100);
			$table->string('email', 150);
			$table->integer('password');
			$table->integer('password_token')->nullable();
			$table->bigInteger('mobile_number');
			$table->integer('otp')->nullable();
			$table->enum('role', array('admin','user'))->default('user');
			$table->enum('status', array('inactive','active'))->default('inactive');
			$table->boolean('is_deleted')->default(0);
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
		Schema::drop('users');
	}

}
