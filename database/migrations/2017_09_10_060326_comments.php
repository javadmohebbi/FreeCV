<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    protected $table_name = 'comments';

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();

            $table->string('name', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('comments', 1000);

            $table->integer('parent_id')->nullable(); // Parent id of comment

            $table->tinyInteger('status'); // 0 = Unread, 1 = Not Approved, 2 = Approved,

            $table->integer('article_id')->unsigned()->nullable();

            $table->timestamps();
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('user_id')->
            references('id')->on('users');
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('article_id')->
            references('id')->on('articles');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table_name);
    }
}
