<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "product_id", "rating", "comment"];

    public function customer()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}