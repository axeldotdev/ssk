<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(500_000)
            ->has(Company::factory()->count(2), 'ownedCompanies')
            ->create();

        User::factory()->create([
            'firstname' => 'Axel',
            'lastname' => 'Charpentier',
            'email' => 'acharpentier@orvea.io',
            'phone' => '+33682507510',
        ]);
    }
}
