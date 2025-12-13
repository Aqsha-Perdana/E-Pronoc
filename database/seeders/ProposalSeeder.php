<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProposalSeeder extends Seeder
{
    public function run()
    {
        DB::table('proposals')->insert([
            [
                'registration_code' => 'REG-' . strtoupper(Str::random(8)),
                'title' => 'Pengembangan Materi Sepak Bola Untuk Kesehatan Remaja',
                'date' => now()->subDays(5),
                'focus_area' => 'Olahraga',
                'focus' => 'Olahraga & Kesehatan',
                'abstract' => 'Penelitian mengeksplorasi potensi tanaman lokal sebagai bahan dasar vaksin herbal.',
                'introduction' => 'Tanaman herbal lokal memiliki potensi besar sebagai obat alternatif.',
                'project_method' => 'Eksperimen laboratorium dan studi klinis awal.',
                'bibliography' => 'Jurnal Herbal Indonesia, WHO Traditional Medicine',
                'statement_letter' => null,
                'status' => 'SUBMITTED',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
