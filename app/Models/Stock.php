<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\models\Price;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticker'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
