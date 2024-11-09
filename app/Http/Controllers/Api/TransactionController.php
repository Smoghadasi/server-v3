<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index($status = null)
    {
        if ($status == 0) {
            $transactions = Transaction::where('userType', ROLE_DRIVER)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['0', null])
                ->orderByDesc('created_at')
                ->paginate(40);
        } else if ($status == 100 || $status == 101) {
            $transactions = Transaction::where('userType', ROLE_DRIVER)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['100', '101'])
                ->orderByDesc('created_at')
                ->paginate(40);
        } else if ($status == 'all') {
            $transactions = Transaction::where('userType', ROLE_DRIVER)
                ->where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->paginate(40);
        }
        return response()->json($transactions, 200);
    }
}
