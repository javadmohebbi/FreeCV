<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Images extends Migration
{
    protected $table_name = 'images';
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
            $table->string('name', 30)->nullable();
            $table->string('desc', 50)->nullable();
            $table->string('path');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
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
        Schema::drop($this->table_name);
    }
}
