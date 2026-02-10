<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;



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

        // ✅ tambahan statistik baru
        $activeProducts = Product::count();

        $archivedProducts = Product::withoutGlobalScopes()
            ->where('is_archived', 1)
            ->count();

        $totalAllProducts = Product::withoutGlobalScopes()->count();

        $stockValue = Product::selectRaw('SUM(current_stock * price) as total')
            ->value('total');
            // statistik stock in vs out
        $stockStats = StockLog::select(
                'type',
                DB::raw('SUM(qty_change) as total')
            )
            ->groupBy('type')
            ->pluck('total','type');

            $monthlyStats = StockLog::selectRaw("
            DATE_FORMAT(created_at, '%Y-%m') as month,
            SUM(CASE WHEN type='in' THEN qty_change ELSE 0 END) as total_in,
            SUM(CASE WHEN type='out' THEN qty_change ELSE 0 END) as total_out
        ")
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        $categoryStats = Product::select(
            'product_categories.name',
            DB::raw('COUNT(products.id) as total')
        )
        ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
        ->groupBy('product_categories.name')
        ->pluck('total','product_categories.name');


        $recentLogs = StockLog::with('product', 'user')->latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'recentLogs',
            'activeProducts',
            'archivedProducts',
            'totalAllProducts',
            'stockValue',
            'stockStats',
            'monthlyStats',
            'categoryStats'
        ));
    }
}
