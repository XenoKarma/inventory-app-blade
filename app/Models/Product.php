<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'sku',
        'product_category_id',
        'price',
        'current_stock',
        'min_stock',
        'is_archived'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }
}
