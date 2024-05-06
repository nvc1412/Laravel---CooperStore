<?php
if (!function_exists('average_rate')) {
    function average_rate($ratings)
    {
        $average_rate = 0;
        foreach ($ratings as $rate) {
            $average_rate += $rate->rating;
        }
        if ($average_rate == 0) {
            return 0;
        }
        return round($average_rate / $ratings->count());
    }
}