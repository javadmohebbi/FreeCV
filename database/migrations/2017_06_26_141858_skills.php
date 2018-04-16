<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Skills extends Migration
{

    protected $table_name = 'skills';

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

            $table->tinyInteger('disabled')->nullable(); // Null = Enabled, Other = Disabled

            $table->tinyInteger('color')->nullable(); // Null = Default, 1 = Danger,
                                                      // 2 = Success, 3 = Warning, 4 = Info
            $table->string('skill');
            $table->tinyInteger('percentage'); // From 0 To 100

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
