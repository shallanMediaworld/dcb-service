<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Config;


class CheckRequestHeaders
{

    public function handle(Request $request, Closure $next)
    {
 

        return $next($request);
    }
}
