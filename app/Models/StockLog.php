<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class StockLog extends Model
{
    //
    protected $fillable = [
        'product_id',
        'type',
        'qty_change',
        'stock_before',
        'stock_after',
        'reason',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
