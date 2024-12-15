<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoRequest;
use App\Models\Logo;
use App\Services\LogoService;

class LogoController extends Controller
{
    protected $logoService;

    public function __construct(LogoService $logoService)
    {
        $this->logoService = $logoService;
    }

    public function index()
    {
        $logos = $this->logoService->getLogos();
        return view("admin.logo.index", compact("logos"));
    }

    public function store(LogoRequest $request)
    {
        if ($this->logoService->createLogo($request->validated())) {
            session()->flash("success", "Thêm logo thành công!");
            return redirect()->route("logo.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function update(LogoRequest $request, Logo $logo)
    {
        if ($this->logoService->updateLogo($request->validated(), $logo)) {
            session()->flash("success", "Cập nhật logo thành công!");
            return redirect()->route("logo.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function destroy(Logo $logo)
    {
        if ($this->logoService->deleteLogo($logo)) {
            session()->flash("success", "Xóa logo thành công!");
            return redirect()->route("logo.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }
}