<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Administrator', 
            'username' => 'admin', 
            'password' => \Hash::make('admin123'),
            'isAdmin' => 1,
        ]);

        \App\User::create([
            'name' => 'Peserta DEMO', 
            'username' => 'peserta', 
            'password' => \Hash::make('peserta123'),
            'isAdmin' => 0,
        ]);
    }
}
