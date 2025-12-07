<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
        'name' => 'researcher1',
        'email' => 'reasecher@gmail.com',
        'password' => Hash::make('123456'),  // Perbaiki HASH menjadi Hash
        'user_group' => 'peneliti'
    ]);
    }
    
}
