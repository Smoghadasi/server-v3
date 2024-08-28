<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderByDesc('sort')->get();
        return response()->json($sliders, 200);
    }
}
