<?php

namespace App;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class Calendar
{
    private function __construct(
        private User $user,
        private CarbonPeriod $period,
        private Collection $meals,
    ) {
    }

    public static function get(User $user, Carbon $from, Carbon $to)
    {
        $period = CarbonPeriod::create($from, $to);
        $meals = $user->meals()
            ->with('foods')
            ->range($from, $to)
            ->get()
            ->groupBy(fn($meal) => $meal->date->toDateString())
        ;

        return new self(
            $user,
            $period,
            $meals,
        );
    }

    public function days(): Collection
    {
        return collect($this->period)
            ->map(fn($day) => new Day($day, $this->meals->get($day->toDateString())))
        ;
    }

    public function meals(): Collection
    {
        return $this->meals;
    }
}
