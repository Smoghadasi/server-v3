<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Load;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $load = Load::findOrFail($request->load_id);
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required',
            'load_id' => 'required',
            // 'owner_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $report = new Report();
        $report->type = $request->type;
        $report->description = $request->description;
        $report->load_id = $request->load_id;
        $report->driver_id = Auth::id();
        // $report->owner_id = $load->user_id;
        $report->save();

        return response()->json('OK', 200);
    }
}
