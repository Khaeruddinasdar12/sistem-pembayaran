<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Admin Super',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '0', //admin
        ]);

        DB::table('admins')->insert([
            'name' => 'Penagih',
            'email' => 'penagih@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '1', //penagih
        ]);
    }
}
