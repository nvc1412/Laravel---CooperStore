<?php

namespace App\Services;

use App\Models\Rating;

class RatingService
{
    public function getRates()
    {
        return Rating::orderBy("created_at", "desc")->paginate(10);
    }

    public function deleteRate($data)
    {
        $rate = Rating::where("id", $data["id"])->firstOrFail();
        return $rate->delete();
    }
}