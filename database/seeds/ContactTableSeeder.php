<?php

use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'id' => 99,
            'language_id' => 1, // English
            'tell' => '+(98)910-19-55-772',
            'email' => 'me@mjmohbbi.com',
            'fb' => 'https://www.facebook.com/pg/Mohammad-Javad-Mohebbi-1697937017175642',
            'tw' => 'https://twitter.com/MohebbiMJ',
            'yt' => 'https://www.youtube.com/channel/UCJMP5bOQPamZVgaViOs-lbw',
            'ig' => 'https://www.instagram.com/mjmohebbi.official',
            'li' => 'https://www.linkedin.com/in/mjmohebbi/',
            'gh' => 'https://github.com/javadmohebbi',
            'tg' => 'https://t.me/official_mjmohebbi',
            'gp' => 'https://plus.google.com/116581675522821580135',
            'pn' => null,
            'user_id' => 99,
        ]);
    }
}
