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
            'name' => 'Ikki',
            'email' => 'ikki@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '0', //admin
        ]);

        DB::table('admins')->insert([
            'name' => 'Tris',
            'email' => 'tris@gmail.com',
            'password' => bcrypt(12345678),
            'status' => '1', //penagih
        ]);
    }
}
