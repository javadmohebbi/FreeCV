<?php

use Illuminate\Database\Seeder;

class BioImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'id' => 99,
            'path' => 'bio.jpg',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
    }
}
