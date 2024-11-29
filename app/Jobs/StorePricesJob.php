<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Price;

class StorePricesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct($ticker, $prices)
    {
        $this->ticker = $ticker;
        $this->prices = $prices;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Price::syncPrices($this->ticker, $this->prices);
    }
}
