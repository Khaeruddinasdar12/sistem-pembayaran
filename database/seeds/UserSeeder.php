<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ramang',
            'email' => 'ramang@gmail.com',
            'username' => 'ramang',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 001/002', 
            'status' => '1' //aktif
        ]);

        DB::table('users')->insert([
            'name' => 'Anwar',
            'username' => 'anwar',
            'email' => 'anwar@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 003/006',
            'status' => '1' //aktif
        ]);

        DB::table('users')->insert([
            'name' => 'Dg. Pajja',
            'username' => 'pajja',
            'email' => 'pajja@gmail.com',
            'password' => bcrypt(12345678),
            'alamat' => 'rt/rw 003/006',
            'status' => '0' //inaktif
        ]);
    }
}
