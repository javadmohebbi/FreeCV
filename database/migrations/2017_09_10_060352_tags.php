<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tags extends Migration
{
    protected $table_name = 'tags';

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

            $table->string('tag', 30);

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
