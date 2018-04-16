<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageTableSeeder::class);
        $this->call(InsertUser::class);


        $this->call(BioTableSeeder::class);
        $this->call(BioImageTableSeeder::class);


        $this->call(ContactTableSeeder::class);


    }
}
