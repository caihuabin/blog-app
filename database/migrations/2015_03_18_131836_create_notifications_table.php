<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('from_user_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->integer('blog_id')->unsigned()->index();
			$table->integer('reply_id')->unsigned()->nullable()->index();
			$table->text('noti_body')->nullable();
			$table->string('type')->index();
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
		//
		Schema::drop('notifications');
	}

}
