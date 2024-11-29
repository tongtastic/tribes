<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stock;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PriceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Stock::factory()->count(20)->create();

        $this->call([
            PriceSeeder::class
        ]);
    }
}
