<?php

use Illuminate\Database\Seeder;

class InsertUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'id' => 99,
            'email' => 'me@mjmohebbi.com',
            'password' => bcrypt('123!@#qwe'),
            'name' => 'admin',
            'is_admin' => 1,
            'enabled' => 1,
        ]);

        \App\UserInformation::create([
            'user_id' => 99,
            'first_name' => 'Mohammad Javad',
            'last_name' => 'Mohebbi'
        ]);
    }
}
