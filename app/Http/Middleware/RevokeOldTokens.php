<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RevokeOldTokens
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentTokenId = PersonalAccessToken::where('tokenable_type', 'App\Models\Driver')->where('tokenable_id', Auth::id())->orderByDesc('created_at')->value('id');

        PersonalAccessToken::where('tokenable_type', 'App\Models\Driver')
            ->where('id', '!=',  $currentTokenId)
            ->orderByDesc('created_at')
            ->delete();

        return $next($request);
    }
}
