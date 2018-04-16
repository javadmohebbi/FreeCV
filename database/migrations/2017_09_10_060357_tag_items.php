<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagItems extends Migration
{
    protected $table_name = 'tag_items';

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

            $table->integer('tag_id')->unsigned()->nullable();
            $table->integer('comment_id')->unsigned()->nullable();
            $table->integer('article_id')->unsigned()->nullable();

            $table->timestamps();
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('tag_id')->
            references('id')->on('tags');
        });
        Schema::table($this->table_name, function($table) {
            $table->foreign('comment_id')->
            references('id')->on('comments');
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
