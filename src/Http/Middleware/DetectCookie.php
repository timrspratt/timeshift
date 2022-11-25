<?php

namespace Timrspratt\Timeshift\Http\Middleware;

use Aero\Common\Facades\Time;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class DetectCookie
{
    public function handle(Request $request, \Closure $next)
    {
        $shift = $request->cookie('timeshift');

        if (is_numeric($shift)) {
            Time::setShift((int) $shift);

            return tap($next($request), function ($response) use ($shift) {
                if ($response instanceof Response
                    && ! $response->isRedirection()
                    && ! $response->isServerError()
                    && Str::contains($response->getContent(), '</body>')
                ) {
                    $html = view('timeshift::banner', [
                        'time' => Time::now(),
                        'link' => URL::temporarySignedRoute('timeshift.generateURL', now()->addHour(), compact('shift')),
                    ]);

                    $response->setContent(
                        Str::replaceFirst('</body>', "{$html->render()}</body>", $response->getContent())
                    );
                }
            });
        }

        return $next($request);
    }
}

