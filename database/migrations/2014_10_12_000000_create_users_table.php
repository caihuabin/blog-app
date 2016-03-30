<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->rememberToken();

            $table->string('realname')->nullable();
            $table->string('telephone')->nullable();
            $table->string('company')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('gender')->default(0);
            $table->string('signature')->nullable();
            $table->string('avatar')->default(Config::get('app.url_static') . '/mobile/image/avatar.png');

            $table->integer('blog_count')->default(0)->index();
            $table->integer('reply_count')->default(0)->index();
            $table->integer('notification_count')->default(0)->index();

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
