<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contacts extends Migration
{

    protected $table_name = 'contacts';

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
            $table->integer('user_id')->unsigned();

            $table->string('tell')->nullable();
            $table->string('email')->nullable();

            $table->string('fb')->nullable(); // Null = Disabled    Facebook
            $table->string('tw')->nullable(); // Null = Disabled    Twitter
            $table->string('yt')->nullable(); // Null = Disabled    Youtube
            $table->string('ig')->nullable(); // Null = Disabled    Instagram
            $table->string('li')->nullable(); // Null = Disabled    LinkedIn
            $table->string('gh')->nullable(); // Null = Disabled    Github
            $table->string('tg')->nullable(); // Null = Disabled    Telegram
            $table->string('gp')->nullable(); // Null = Disabled    Google+
            $table->string('pn')->nullable(); // Null = Disabled    Pinterest


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
