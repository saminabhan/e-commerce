<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_invoice_number',
        'name',
        'phone',
        'zip',
        'state',
        'city',
        'address',
        'locality',
        'landmark',
        'subtotal',
        'vat',
        'total',
        'status',
        'payment_method',
        'stripe_charge_id',
        'transaction_id',
        'is_confirmed',
        'confirmation_expires_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'confirmation_expires_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    public function getPaymentMethodDisplayAttribute()
    {
        return match($this->payment_method) {
            'cash_on_delivery' => 'Cash on Delivery',
            'bank_transfer' => 'Bank Transfer',
            'check_payment' => 'Check Payment',
            'stripe' => 'Credit/Debit Card',
            default => ucwords(str_replace('_', ' ', $this->payment_method))
        };
    }
    public function trackings()
    {
    return $this->hasMany(OrderTracking::class);
    }

    public function tracking()
    {
    return $this->hasMany(OrderTracking::class);
    }

    public function orderItems()
    {
    return $this->hasMany(OrderItem::class);
    }

}