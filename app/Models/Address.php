<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // الحقول التي يمكن تعيينها بشكل جماعي
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zip',
        'state',
        'city',
        'address',
        'locality',
        'landmark',
        'is_default',
    ];

    // cast لتحويل is_default إلى boolean تلقائياً
    protected $casts = [
        'is_default' => 'boolean',
    ];

    // العلاقة مع المستخدم (كل عنوان يخص مستخدم واحد)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
