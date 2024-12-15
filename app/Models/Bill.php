<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "email", "phone", "address", "note", "payment", "status", "total"];

    public function customer()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function details()
    {
        return $this->hasMany(BillDetail::class, "bill_id", "id");
    }
}
