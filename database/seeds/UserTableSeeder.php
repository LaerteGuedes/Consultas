<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();


        User::create([

            'role_id'  => 1,
            'name'     => 'admin',
            'lastname' => '',
            'email'    => 'lordhugomac@gmail.com',
            'password' => bcrypt('teste'),
            'phone'    => '(91) 98522-4004'

        ]);


    }
}
