<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'status', 'note', 'tracked_at'];

    protected $casts = [
        'tracked_at' => 'datetime',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

}
