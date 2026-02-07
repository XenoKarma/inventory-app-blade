<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('products')->where(function ($query) use ($request){
                    $query->whereRaw('LOWER(name) = ?', [strtolower($request->name)]);
                })
            ],
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        // ✅ SKU AUTO GENERATOR
        $sku = $request->sku;
        if (!$sku) {
            $lastId = Product::max('id') + 1;
            $sku = 'BRG-' . date('Y') . '-' . str_pad($lastId, 3, '0', STR_PAD_LEFT);
        }

        Product::create([
            'name' => $request->name,
            'sku' => $sku,
            'product_category_id' => $request->product_category_id,
            'price' => $request->price,
            'current_stock' => $request->current_stock,
            'min_stock' => $request->min_stock,
        ]);

        return redirect()->route('products.index')
            ->with('success','Product berhasil ditambahkan');
    }

    // nambahin stock diinget yah
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
        'qty' => 'required|integer|min:1',
        'reason' => 'required'
    ]);

    DB::transaction(function () use ($request, $product) {

        $before = $product->current_stock;
        $after  = $before + $request->qty;

        $product->update([
            'current_stock' => $after
        ]);

        \App\Models\StockLog::create([
            'product_id' => $product->id,
            'type' => 'in',
            'qty_change' => $request->qty,
            'stock_before' => $before,
            'stock_after' => $after,
            'reason' => $request->reason,
            'user_id' => auth()->id()
        ]);
    });
    $message = 'Stok berhasil ditambahkan';
    if ($product->current_stock < $product->min_stock) {
        $message .= ' — ⚠️ STOK KRITIS';
    }

    return back()->with('success', $message);
    }

    // ngurangin stock
    public function reduceStock(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'reason' => 'required'
        ]);

        DB::transaction(function () use ($request, $product) {

            $before = $product->current_stock;
            $after  = $before - $request->qty;

            if ($after < 0) {
                abort(400,'Stok tidak cukup');
            }

            $product->update([
                'current_stock' => $after
            ]);

            \App\Models\StockLog::create([
                'product_id' => $product->id,
                'type' => 'out',
                'qty_change' => $request->qty,
                'stock_before' => $before,
                'stock_after' => $after,
                'reason' => $request->reason,
                'user_id' => auth()->id()
            ]);
        });
        $message = 'Stok berhasil dikurangi';
        if ($product->current_stock < $product->min_stock) {
            $message .= ' — ⚠️ STOK KRITIS';
        }

        return back()->with('success', $message);
    }
}
