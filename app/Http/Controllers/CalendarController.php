<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class  CalendarController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->get('from', now()->firstOfMonth());
        $to = $request->get('to', now()->endOfMonth());

        // need to add the meals into that
        return view('calendar.index', [
            'days' => $request->user()->meals()->range($from, $to)->get(),
        ]);
    }
}
