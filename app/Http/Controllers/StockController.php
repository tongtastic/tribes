<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Resources\StockResource;

class StockController extends Controller
{
    public function index(Request $request)
    {
        return new StockResource(Stock::paginate(100));
    }

    public function show(Request $request)
    {
        return new StockResource(Stock::findOrFail($request->id));
    }
}
