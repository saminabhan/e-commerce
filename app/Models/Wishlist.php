<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'product_name', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

   
    public function getCurrentPriceAttribute()
    {
        if ($this->product) {
            return $this->product->sale_price ?? $this->product->regular_price;
        }
        return null;
    }
}
