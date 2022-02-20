<?php

namespace App\Enums;

enum MealType: int {
    case Breakfast = 1;
    case Lunch = 2;
    case Afternoon = 3;
    case Dinner = 4;

    public function label(): string
    {
        return match($this)
        {
            self::Breakfast => 'Breakfast',
            self::Lunch => 'Lunch',
            self::Afternoon => 'Afternoon',
            self::Dinner => 'Dinner',
        };
    }
}
