<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;

class SupportCallController extends Controller
{
    public function storeDriver()
    {
        $support = new Support();
        $support->type = 'Driver';
        $support->driver_id = Auth::id();
        $support->save();
        return response()->json('با موفقیت ثبت شد', 200);
    }
}
