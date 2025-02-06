<?php

namespace App\Http\Middleware;

use App\Models\Gateway;
use Closure;
use Illuminate\Http\Request;

class GatewayActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $gateway_id = $request->gateway_id;
        $gateway = Gateway::find($gateway_id);
        if (is_null($gateway) || $gateway->status == 0) {
            return response()->json(["response_status" => false, "response_message" => "gateway_not_active"]);
        }

        return $next($request);
    }
}
