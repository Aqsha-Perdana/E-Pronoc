<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proposal_teams')->insert([
            [
                'proposal_id' => 1,
                'member_id'   => 1,
                'role'        => 'Ketua',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'proposal_id' => 1,
                'member_id'   => 2,
                'role'        => 'Anggota',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'proposal_id' => 1,
                'member_id'   => 3,
                'role'        => 'Anggota',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'proposal_id' => 2,
                'member_id'   => 1,
                'role'        => 'Ketua',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'proposal_id' => 2,
                'member_id'   => 4,
                'role'        => 'Anggota',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
