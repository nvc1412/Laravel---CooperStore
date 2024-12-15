<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Services\BannerService;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $banners = $this->bannerService->getBanners();
        return view("admin.banner.index", compact("banners"));
    }

    public function store(BannerRequest $request)
    {
        if ($this->bannerService->createBanner($request->validated())) {
            session()->flash("success", "Thêm banner thành công!");
            return redirect()->route("banner.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function edit(Banner $banner)
    {
        return view("admin.banner.edit", compact("banner"));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        if ($this->bannerService->updateBanner($request->validated(), $banner)) {
            session()->flash("success", "Cập nhật banner thành công!");
            return redirect()->route("banner.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function destroy(Banner $banner)
    {
        if ($this->bannerService->deleteBanner($banner)) {
            session()->flash("success", "Xóa banner thành công!");
            return redirect()->route("banner.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }
}