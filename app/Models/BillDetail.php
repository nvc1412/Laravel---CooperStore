<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = ["bill_id", "product_id", "product_detail_id", "quantity", "price"];

    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }

    public function size()
    {
        return $this->hasOne(ProductDetail::class, "id", "product_detail_id");
    }
}
