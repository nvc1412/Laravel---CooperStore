<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $rates = Rating::orderBy("created_at", "desc")->paginate(10);
        return view("admin.rating.index", compact("rates"))->with("i", (request()->input("page", 1) - 1) * 10);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            "id" => "required|exists:ratings,id",
        ]);
        $rate = Rating::where("id", $request->id)->firstOrFail();
        if($rate->delete()){
            return redirect()->route("rating.index")->with("success", "Xóa bình luận thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }
}