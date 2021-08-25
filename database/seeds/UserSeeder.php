<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ramang',
            'email' => 'ramang@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 001/002', 
        ]);

        DB::table('users')->insert([
            'name' => 'Anwar',
            'email' => 'anwar@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 003/006',
        ]);

        DB::table('users')->insert([
            'name' => 'Dg. Pajja',
            'email' => 'pajja@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 003/006',
        ]);
    }
}
