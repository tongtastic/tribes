<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'volume',
        'discardable'
    ];

    protected $hidden = [
        'id',
        'stock_id',
        'discardable',
        'created_at',
        'updated_at'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public static function syncPrices(string $ticker, array $prices)
    {
        $stock = Stock::where('ticker', $ticker)->first();

        foreach($prices as $price) {
            self::firstOrCreate([
                'stock_id' => $stock->id,
                'timestamp' => $price['timestamp'],
                'price' => $price['price']
            ],
            [
                'volume' => $price['volume']
            ]);
        }
    }

    public static function range(int $id, string $range = 'max')
    {
        switch($range) {
            case '1d':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case '5d':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subDays(5)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case '1m':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subMonths(1)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case '6m':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subMonths(6)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case 'ytd':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subYears(1)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case '5y':
                return self::where('stock_id', $id)
                    ->whereBetween('timestamp', [
                        Carbon::now()->subYears(5)->format('Y-m-d H:i:s'),
                        Carbon::now()
                    ])
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
            case 'max':
                return self::where('stock_id', $id)
                    ->orderBy('timestamp', 'desc')
                    ->get();
            break;
        }
    }
}
