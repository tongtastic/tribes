<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StocksApiService {

    public static function getPriceHistory(string $ticker)
    {
        $response = Http::get('http://api.stocks-api.test/stocks/' . $ticker . '/history');
        if($response->successful()) {
            return json_decode($response->body());
        }
        return false;
    }
}