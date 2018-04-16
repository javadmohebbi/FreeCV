<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleCategories extends Migration
{
    protected $table_name = 'article_categories';

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

            $table->string('name', 100);

            $table->string('desc', 400)->nullable();

            $table->tinyInteger('enabled'); // 1 = Yes, 2 = No
            $table->tinyInteger('priority')->nullable();

            $table->tinyInteger('parent_category_id')->nullable();

            $table->integer('user_id')->unsigned()->nullable();

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
