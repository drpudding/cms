<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('post_id')->unsigned();
			$table->text('content');
			$table->boolean('status')->default(false)->index();
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade')
                ->onUpdate('cascade');
			$table->foreign('post_id')
				->references('id')->on('posts')
				->onDelete('cascade')
                ->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
