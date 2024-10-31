<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistorySearchDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HistorySearchDriverController extends Controller
{
    public function index()
    {
        $historySearchDrivers = HistorySearchDriver::with('fromCity', 'toCity')
            ->where('driver_id', Auth::id())
            ->orderByDesc('count')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        return response()->json($historySearchDrivers, 200);
    }

    public function store(Request $request)
    {
        try {
            // Fetch the history search driver
            $historySearchDriver = HistorySearchDriver::where([
                ['from_city_id', $request->from_city_id],
                ['to_city_id', $request->to_city_id],
                ['driver_id', $request->driver_id],
            ])->first();

            if ($historySearchDriver) {
                // Increment the count if the entry exists
                $historySearchDriver->count += 1;
                $historySearchDriver->save();
            } else {
                // Count existing entries
                $historySearchDriverOldCount = HistorySearchDriver::where([
                    ['from_city_id', $request->from_city_id],
                    ['to_city_id', $request->to_city_id],
                    ['driver_id', $request->driver_id],
                ])->count();

                // Delete the oldest entry if the count is 5 or more
                if ($historySearchDriverOldCount >= 5) {
                    HistorySearchDriver::where([
                        ['from_city_id', $request->from_city_id],
                        ['to_city_id', $request->to_city_id],
                        ['driver_id', $request->driver_id],
                    ])
                        ->orderBy('created_at', 'asc')
                        ->first()
                        ->delete();
                }

                // Create a new entry
                HistorySearchDriver::create([
                    'from_city_id' => $request->from_city_id,
                    'to_city_id' => $request->to_city_id,
                    'driver_id' => Auth::id(),
                ]);
            }

            return response()->json('OK', 200);
        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
        }
    }
}
