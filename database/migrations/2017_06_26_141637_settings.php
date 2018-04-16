<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
    protected $table_name = 'settings';

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

            $table->integer('fav_icon_image_id')->unsigned()->nullable();

            $table->text('title')->nullable(); // WEB Title
            $table->text('keywords')->nullable(); // WEB Keywords
            $table->text('description')->nullable(); // WEB Description

            $table->string('menu_long_title', 20)->nullable(); // Like: MJ MOHEBBI
            $table->string('menu_short_title', 6)->nullable(); // Like: MJ MOHEBBI

            $table->tinyInteger('bio_enabled'); // 1 = YES, 2 = NO
            $table->tinyInteger('projects_enabled'); // 1 = YES, 2 = NO
            $table->tinyInteger('skills_enabled'); // 1 = YES, 2 = NO
            $table->tinyInteger('experiences_enabled'); // 1 = YES, 2 = NO
            $table->tinyInteger('contacts_enabled'); // 1 = YES, 2 = NO
            $table->tinyInteger('kb_enabled'); // 1 = YES, 2 = NO

            $table->text('custom_js')->nullable(); // 1 = YES, 2 = NO
            $table->text('custom_css')->nullable(); // 1 = YES, 2 = NO
            $table->text('google_analytics')->nullable(); // 1 = YES, 2 = NO


            $table->timestamps();
        });

        Schema::table($this->table_name, function($table) {
            $table->foreign('fav_icon_image_id')->
            references('id')->on('images');
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
