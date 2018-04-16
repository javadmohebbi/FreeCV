<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Articles extends Migration
{
    protected $table_name = 'articles';

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

            $table->integer('language_id')->unsigned();

            $table->string('title', 100);
            $table->string('slug', 200)->unique();
            $table->string('summary', 1000);

            $table->tinyInteger('enabled'); // 1 = Enabled , 2 = Disabled

            $table->text('html_summary')->nullable();

            $table->text('html_desc')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('article_category_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();

            $table->integer('viewed')->unsigned()->nullable();

            $table->timestamps();
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('language_id')->
            references('id')->on('languages');
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('user_id')->
            references('id')->on('users');
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('article_category_id')->
            references('id')->on('article_categories');
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('image_id')->
            references('id')->on('images');
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
