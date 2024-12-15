<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = ["image", "prioty", "position", "status", "link"];

    public function scopeGetLogo($query, $position = "Header-Logo")
    {
        $query = $query->where("status", "Hiện")->where("position", $position)->orderBy("prioty", "ASC")->select("link", "image", "position", "prioty");
        return $query;
    }
}