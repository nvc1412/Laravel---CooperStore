<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "product_id", "product_detail_id", "price", "quantity"];

    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class, "id", "product_detail_id");
    }
}