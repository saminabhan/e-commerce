<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TempUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'verification_code',
        'verification_code_expires_at',
    ];

    protected $casts = [
        'verification_code_expires_at' => 'datetime',
    ];

    /**
     * Check if verification code is expired
     */
    public function isCodeExpired()
    {
        return Carbon::now()->gt($this->verification_code_expires_at);
    }

    /**
     * Generate new verification code
     */
    public function generateVerificationCode()
    {
        $this->verification_code = rand(100000, 999999);
        $this->verification_code_expires_at = Carbon::now()->addMinutes(5);
        $this->save();
        
        return $this->verification_code;
    }
}