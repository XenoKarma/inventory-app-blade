<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\NotArchivedScope;


class Product extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new NotArchivedScope);
    }
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
