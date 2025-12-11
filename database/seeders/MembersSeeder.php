<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'nip'   => '19870101200101',
                'name'  => 'Andi Saputra',
                'email' => 'andi@example.com',
                'role'  => 'Ketua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip'   => '19900215201402',
                'name'  => 'Budi Santoso',
                'email' => 'budi@example.com',
                'role'  => 'Anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip'   => '19930521201503',
                'name'  => 'Citra Dewi',
                'email' => 'citra@example.com',
                'role'  => 'Anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip'   => '19970112201804',
                'name'  => 'Dimas Pratama',
                'email' => 'dimas@example.com',
                'role'  => 'Anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }}
