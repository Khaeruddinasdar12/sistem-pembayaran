<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Khaeruddin Asdar',
            'email' => 'khaeruddinasdar12@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '0', //admin
        ]);

        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '1', //penagih
        ]);

        DB::table('admins')->insert([
            'name' => 'Penagih',
            'email' => 'penagih@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '1', //penagih
        ]);
    }
}
