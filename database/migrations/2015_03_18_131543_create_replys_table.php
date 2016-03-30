<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('replys', function(Blueprint $table)
		{
			$table->increments('id');
			/*$table->text('reply_body_original')->nullable();*/
			$table->text('reply_body');
			$table->integer('user_id')->unsigned()->index();
			$table->integer('blog_id')->unsigned()->index();
			$table->integer('reply_id')->unsigned()->default(0)->index();
			$table->boolean('is_block')->index()->default(false);
			$table->integer('vote_count')->index()->default(0);
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
		Schema::drop('replys');
	}

}
