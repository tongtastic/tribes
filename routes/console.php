<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Price;
use Carbon\Carbon;

Schedule::call(function() {
    Price::whereBetween('created_at', [
        Carbon::now()->subDays(7)->format('Y-m-d H:i:s'),
        Carbon::now()
    ])
    ->andWhere('discardable', 1)
    ->delete();
})->hourly();