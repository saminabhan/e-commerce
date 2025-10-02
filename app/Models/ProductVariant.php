<?php

// app/Models/ProductVariant.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity',
        'images'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attributes',
            'variant_id',
            'attribute_value_id'
        );
    }

    // Helper: Get variant display name
    public function getDisplayNameAttribute()
    {
        $attributes = $this->attributeValues->pluck('value')->implode(' - ');
        return $this->product->name . ' (' . $attributes . ')';
    }
}