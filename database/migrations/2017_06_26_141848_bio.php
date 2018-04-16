<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bio extends Migration
{

    protected $table_name = 'bio';

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

            $table->integer('image_id')->unsigned()->nullable();

            $table->text('bio');

        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('language_id')->
            references('id')->on('languages');
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
