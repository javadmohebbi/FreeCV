<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleImagesTable extends Migration
{

    protected $table_name = 'article_images';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_images', function (Blueprint $table) {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->integer('article_id')->unsigned()->nullable();
            $table->integer('image_id')->unsigned()->nullable();
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('article_id')->
            references('id')->on('articles');
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
