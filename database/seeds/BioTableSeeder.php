<?php

use Illuminate\Database\Seeder;

class BioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bio')->insert([
            'language_id' => 1,
            'image_id' => null,
            'bio' => 'My full name is "Mohammad Javad Mohebbi" (but friends usually call me "Mohammad", "Javad" or "MJ" - I myself prefer to be called "Javad"). I have more than 8 years experience in Computer industry. I really really and again really motivated by new challenges and take excellent approach to achieve success (Hopefully most of the time!). I have experience in working with different operating system and platforms (I found myself happier when i am working with Linux!)<br/><br/> As long as i fallen in love with information security and also open source projects, these recent years i completed some courses about security like "CEH", "CISSP", "Fraud Prevention" and "Industial Cyber Security" and try to create open source project which i mentioned it in <a href="#projects" class="goto" title="projects">Projects & Activities</a>. <br/><br/> Do get in touch! <a href="#contact" title="contact" class="goto">Contact Me!</a>',
        ]);
    }
}
