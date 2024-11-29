<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Stock;
use App\models\Price;
use Carbon\Carbon;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = Stock::all();
        $total = 1000;
        $current = 0;
        $time = Carbon::now();
        while($current <= $total) {
            $time = $time->subMinutes(30);
            foreach($stocks as $stock) {
                Price::factory([
                    'timestamp' => $time
                ])
                ->for($stock)
                ->create();
            }
            $current++;
        }
    }
}
