<?php

namespace App\Http\Controllers;

use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class  CalendarController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->get('from') ? Carbon::create($request->get('from')) : now()->startOfMonth();
        $to = $request->get('to') ? Carbon::create($request->get('to')) : now()->endOfMonth();

        $calendar = Calendar::get($request->user(), $from, $to);

        // need to add the meals into that
        return view('calendar.index', [
            'calendar' => $calendar,
        ]);
    }
}
