<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BitrixPortal;
use Symfony\Component\HttpFoundation\Response;

class VerifyBitrixSignature
{
    public function handle(Request $request, Closure $next): Response {
        $memberId = $request->input('member_id');
        $applicationToken = $request->input('application_token');

        if (!$memberId || !$applicationToken) {
            abort(403, 'Missing member_id or application_token');
        }

        $portal = BitrixPortal::where('member_id', $memberId)->first();

        if (!$portal || !$portal->application_token) { abort(403, 'Application token not set for this portal'); }
        if (!hash_equals($portal->application_token, $applicationToken)) { abort(403, 'Invalid application_token'); }

        return $next($request);
    }
}