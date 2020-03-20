<?php

namespace Timrspratt\Timeshift\Http\Controllers;

use Aero\Admin\Http\Controllers\Controller;
use Aero\Common\Facades\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimeshiftController extends Controller
{
    public function index(Request $request)
    {
        $shift = $request->cookie('timeshift');

        $stamp = null;

        if ($shift !== null && is_numeric($shift)) {
            $stamp = Time::getShiftedNow((int) $shift);
        }

        return view('timeshift::index', compact('stamp'));
    }

    public function set(Request $request)
    {
        $data = $this->validate($request, [
            'timestamp' => 'nullable|date',
        ]);

        if ($data['timestamp']) {
            $now = Time::now();
            $shift = Carbon::parse($data['timestamp']);
            $seconds = $now->diffInSeconds($shift);

            if ($now->isAfter($shift)) {
                $seconds *= -1;
            }

            $cookie = cookie()->make('timeshift', $seconds, 120, '/');
        } else {
            $cookie = cookie()->forget('timeshift');
        }

        return back()
            ->withCookie($cookie)
            ->with([
                'message' => 'Date and time have been set',
            ]);
    }
}
