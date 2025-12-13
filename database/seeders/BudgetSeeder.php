<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budgets;
use App\Models\Proposal; // Pastikan model Proposal ada
use Faker\Factory as Faker;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua proposal yang ada
        $proposals = Proposal::all();

        // Jika tidak ada proposal, seeder berhenti
        if ($proposals->isEmpty()) {
            $this->command->info('No proposals found, skipping Budget seeding.');
            return;
        }

        foreach ($proposals as $proposal) {
            // Membuat antara 1-3 budget per proposal
            for ($i = 0; $i < rand(1, 3); $i++) {
                Budgets::create([
                    'proposal_id' => $proposal->id,
                    'direct_personnel_cost' => $faker->randomFloat(2, 1000, 10000),
                    'non_personnel_cost' => $faker->randomFloat(2, 500, 5000),
                    'indirect_cost' => $faker->randomFloat(2, 200, 2000),
                    'document_rab' => $faker->optional()->filePath(), // file path dummy
                    'status' => $faker->randomElement(['draft', 'submitted', 'approved', 'rejected']),
                ]);
            }
        }

        $this->command->info('Budget table seeded successfully.');
    }
}
