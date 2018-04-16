<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English',
            'short' => 'en',
            'enabled' => 1,
            'is_rtl' => 2 // LTR
        ]);
        DB::table('languages')->insert([
            'name' => 'پارسی',
            'short' => 'fa',
            'enabled' => 1,
            'is_rtl' => 1 // RTL
        ]);
    }
}
