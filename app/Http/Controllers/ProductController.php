<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Scopes\NotArchivedScope;


class ProductController extends Controller
{
    public function archived()
    {
        $products = Product::withoutGlobalScope(NotArchivedScope::class)
            ->where('is_archived', true)
            ->with('category')
            ->paginate(10);

        return view('products.archived', compact('products'));
    }


public function index()
{
    $perPage = request('per_page', 10);

    $query = Product::with('category')
        ->where('is_archived', 0);

    // 🔍 search
    if ($s = request('search')) {
        $query->where(function ($q) use ($s) {
            $q->where('name', 'like', "%$s%")
              ->orWhere('sku', 'like', "%$s%");
        });
    }

    // 🧩 filter kategori
    if ($cat = request('category')) {
        $query->where('product_category_id', $cat);
    }

    // ⬆️⬇️ sort
    $sort = request('sort', 'id');
    $dir  = request('dir', 'desc');

    $query->orderBy($sort, $dir);

    $products = $query->paginate($perPage)->withQueryString();

    $categories = ProductCategory::orderBy('name')->get();

    return view('products.index', compact('products','categories'));
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
    public function archive(Product $product)
    {
        $product->is_archived = true;
        $product->save();

        return back()->with('success', 'Produk diarsipkan');
    }

    public function restore($id)
    {
        $product = Product::withoutGlobalScope(
            \App\Models\Scopes\NotArchivedScope::class
        )->findOrFail($id);

        $product->is_archived = false;
        $product->save();

        return back()->with('success', 'Produk direstore');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return back()->with('error','Tidak ada produk dipilih');
        }

        Product::whereIn('id', $ids)->delete();

        return back()->with('success','Produk terpilih berhasil dihapus permanen');
    }



    public function destroy(Product $product)
    {
        $product->is_archived = true;
        $product->save();

        return back()->with('success', 'Produk berhasil dihapus (diarsipkan)');
    }

    // ini untuk edit product
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    // hasil setelah edit product kita pakailah itu method update
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'nullable|unique:products,sku,' . $product->id,
            'product_category_id' => 'required',
            'price' => 'required|numeric',
            'current_stock' => 'required|integer',
            'min_stock' => 'required|integer',
        ]);

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil diupdate');
    }




}
