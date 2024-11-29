<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PriceResource;
use App\Models\Stock;
use App\Models\Price;
use App\Jobs\StorePricesJob;
use App\Services\StocksApiService;

class PriceController extends Controller
{
    public function filter(Request $request)
    {
        $range = $request->range ?? 'max';

        if(Cache::has($request->id . '-' . $range)) {
            $prices = Cache::get($request->id . '-' . $range);
            return new PriceResource($prices);
        }

        $stock = Stock::findOrFail($request->id);
        $prices = StocksApiService::getPriceHistory($stock->ticker);

        if($prices) {
            StorePricesJob::dispatch($request->ticker, $prices);
            switch($range) {
                case '1d':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInDays(Carbon::now());
                        if($diff > 1) {
                            unset($prices[$key]);
                        }
                    }
                break;
                case '5d':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInDays(Carbon::now());
                        if($diff > 5) {
                            unset($prices[$key]);
                        }
                    }
                break;
                case '1m':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInMonths(Carbon::now());
                        if($diff > 1) {
                            unset($prices[$key]);
                        }
                    }
                break;
                case '6m':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInMonths(Carbon::now());
                        if($diff > 6) {
                            unset($prices[$key]);
                        }
                    }
                break;
                case 'ytd':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInYears(Carbon::now());
                        if($diff > 1) {
                            unset($prices[$key]);
                        }
                    }
                break;
                case '5y':
                    foreach($prices as $key => $price) {
                        $diff = Carbon::parse($price->timestamp)->diffInYears(Carbon::now());
                        if($diff > 5) {
                            unset($prices[$key]);
                        }
                    }
                break;
            }
            Cache::put($request->id . '-' . $range, 600, $prices);
            return new PriceResource($prices);
        }

        $prices = Price::range($request->id, $range)->toArray();

        if(count($prices) > 0) {
            return new PriceResource($prices);
        }

        return response(402);
    }
}
