<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $appends = ["favorited"];
    protected $fillable = ["category_id", "name", "short_description", "description", "image", "price", "discount", "quantity"];

    // public function cat()
    // {
    //     return $this->hasOne(Category::class, "id", "category_id");
    // }

    public function images()
    {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }

    public function sizes()
    {
        return $this->hasMany(ProductDetail::class, "product_id", "id");
    }
    public function getFavoritedAttribute()
    {
        $favorited = Favorite::where(["user_id" => auth()->id(), "product_id" => $this->id])->first();
        return $favorited ? true : false;
    }

    public function ratings(){
        return $this->hasMany(Rating::class, "product_id", "id")->orderBy("created_at", "desc");
    }
}