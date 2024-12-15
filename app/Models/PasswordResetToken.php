<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $fillable = ["email", "token"];

    public function customer()
    {
        return $this->hasOne(User::class, "email", "email");
    }

    public function scopeCheckToken($query, $token)
    {
        return $query->where("token", $token)->firstOrFail();
    }

    public function scopeDeleteToken($query, $token)
    {
        return $query->where("token", $token)->delete();
    }
}