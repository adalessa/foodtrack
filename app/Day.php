<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Day
{
    private Collection $meals;

    public function __construct(
        private Carbon $date,
        ?Collection $meals,
    ) {
        $this->meals = $meals ? $meals->mapWithKeys(function ($meal) {
            return [$meal->type->value => $meal];
        })->sortKeys() : collect();
    }

    /**
     * @param \Illuminate\Support\Collection<\App\Model\Meal>
     */
    public function meals(): Collection
    {
        return $this->meals;
    }

    public function date(): Carbon
    {
        return $this->date;
    }
}
