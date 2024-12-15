<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRateRequest;
use App\Services\RatingService;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function index()
    {
        $rates = $this->ratingService->getRates();
        return view("admin.rating.index", compact("rates"));
    }
    public function destroy(DeleteRateRequest $request)
    {
        try {
            $this->ratingService->deleteRate($request->validated());
            session()->flash("success", "Xóa bình luận thành công!");
            return redirect()->route("rating.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}