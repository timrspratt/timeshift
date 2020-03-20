<?php

namespace Timrspratt\Timeshift\Http\Middleware;

use Aero\Common\Facades\Time;
use Illuminate\Http\Request;

class DetectCookie
{
    public function handle(Request $request, \Closure $next)
    {
        $shift = $request->cookie('timeshift');

        if ($shift !== null && is_numeric($shift)) {
            Time::setShift((int) $shift);
        }

        return $next($request);
    }
}

