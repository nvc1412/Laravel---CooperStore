<?php

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return auth()->user()->is_admin == 1;
    }
}

if (!function_exists('isActive')) {
    function isActive()
    {
        return auth()->user()->status == 0;
    }
}

if (!function_exists('isEmailVerified')) {
    function isEmailVerified()
    {
        return auth()->user()->email_verified_at;
    }
}

if (!function_exists("addImage")) {
    function addImage($data, $folder)
    {
        // Add image in folder
        $img_name = $data->hashName();
        return $data->move(public_path("img/" . $folder), $img_name) ? $img_name : false;
    }
}

if (!function_exists("deleteImage")) {
    function deleteImage($img_name, $folder)
    {
        $img_path = public_path("img/" . $folder) . "/" . $img_name;
        // Delete logo in folder
        if (file_exists($img_path) && $img_name != null) {
            unlink($img_path);
        }
    }
}

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