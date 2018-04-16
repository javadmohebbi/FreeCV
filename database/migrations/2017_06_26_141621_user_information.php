<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserInformation extends Migration
{

    protected $table_name = 'user_information';


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

            $table->integer('language_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned();

            $table->integer('image_id')->unsigned()->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('tell')->nullable();
            $table->string('mobile')->nullable();

            $table->tinyInteger('gender')->nullable(); // 1 = Male, 2 = Female, 3 = Other, Null = Rather not to say

            $table->timestamps();
        });


        Schema::table($this->table_name, function($table) {
            $table->foreign('image_id')->
            references('id')->on('images');
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('user_id')->
            references('id')->on('users');
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('language_id')->
            references('id')->on('languages');
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
