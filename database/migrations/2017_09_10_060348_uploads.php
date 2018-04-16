<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uploads extends Migration
{

    protected $table_name = 'uploads';

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

            $table->string('name', 30);
            $table->string('desc', 50)->nullable();
            $table->string('path');
            $table->string('extension', 4); // Extension Type
            $table->tinyInteger('type'); /* 1 = Blog
                                          * 2 = Other
                                          */


            $table->integer('user_id')->unsigned()->nullable();

            $table->timestamps();
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
