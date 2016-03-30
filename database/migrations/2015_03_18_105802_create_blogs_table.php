<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('blogs', function(Blueprint $table) 
		{
			$table->increments('id');
			$table->string('title')->index();
			$table->text('blog_body');
			$table->text('image_list')->nullable();

			$table->integer('user_id')->index();
			$table->integer('last_reply_user_id')->default(0)->index();
			
			$table->integer('order')->default(0)->index();
			
			$table->boolean('is_excellent')->default(false)->index();
			$table->boolean('is_wiki')->default(false)->index();
			$table->boolean('is_blocked')->default(false)->index();
			
			$table->integer('reply_count')->default(0)->index();
			$table->integer('view_count')->default(0)->index();
			$table->integer('vote_count')->default(0)->index();
			/*$table->text('excerpt')->nullable();
			$table->integer('node_id')->index();
			$table->text('blog_body_original')->nullable();*/
			
			$table->softDeletes();
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
		Schema::drop('blogs');
	}

}
