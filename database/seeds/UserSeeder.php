<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Mansyur',
            'email' => 'mansyur@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 001/002', 
        ]);

        DB::table('users')->insert([
            'name' => 'Rispo',
            'email' => 'rispo@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 003/006',
        ]);
    }
}
