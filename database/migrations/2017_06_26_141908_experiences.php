<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Experiences extends Migration
{

    protected $table_name = 'experiences';

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

            $table->string('name');

            $table->tinyInteger('disabled')->nullable(); // Null = Enabled, Other = Disabled

            $table->string('from_month')->nullable();
            $table->integer('from_year');

            $table->tinyInteger('is_present'); // 1 = Yes, 2 = Null
            $table->string('to_month')->nullable(); // Null = Present
            $table->integer('to_year')->nullable(); // Null = Present

            $table->string('link')->nullable();
            $table->text('description');

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
