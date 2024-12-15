<?php

namespace App\Services;

use App\Models\Logo;

class LogoService
{
    public function getLogos()
    {
        return Logo::orderBy("position", "ASC")->paginate(10);
    }

    public function createLogo($data)
    {
        $data["image"] = addImage($data["image"], "logos");
        return Logo::create($data);
    }

    public function updateLogo($data, Logo $logo)
    {
        if (isset($data["image"])) {
            $data["image"] = addImage($data["image"], "logos");
            if (!$data["image"]) {
                return false;
            }
            deleteImage($logo->image, "logos");
        }

        return $logo->update($data);
    }

    public function deleteLogo(Logo $logo)
    {
        return $logo->delete();
    }
}