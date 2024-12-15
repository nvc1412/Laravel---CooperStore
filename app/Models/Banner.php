<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = ["name", "description", "image", "prioty", "position", "status", "link"];

    public function scopeGetBanner($query, $position = "Top-Banner")
    {
        $query = $query->where("status", "Hiện")->where("position", $position)->orderBy("prioty", "ASC")->select("link", "image", "position", "prioty");
        return $query;
    }
}