<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillVerifyToken extends Model
{
    use HasFactory;

    protected $fillable = ["email", "bill_id", "token"];

    public function bill()
    {
        return $this->hasOne(Bill::class, "id", "bill_id");
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
