<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(1_000)
            ->has(Company::factory()->count(2), 'ownedCompanies')
            ->create();

        User::factory()->notOnboarded()->create([
            'firstname' => 'Axel',
            'lastname' => 'Charpentier',
            'email' => 'acharpentier@orvea.io',
            'phone' => '+33682507510',
        ]);
    }
}
