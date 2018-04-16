<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Languages extends Migration
{

    protected $table_name = 'languages';

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
            $table->string('short', 50);
            $table->tinyInteger('enabled')->nullable(); // 1 = Yes, 2 = No
            $table->tinyInteger('is_rtl')->nullable(); // 1 = Yes, 2 = No
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
