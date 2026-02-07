<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::whereColumn(
            'current_stock',
            '<',
            'min_stock'
        )->count();

        $recentLogs = StockLog::with('product', 'user')->latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'recentLogs'
        ));
    }
}
