<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self breakfast()
 * @method static self lunch()
 * @method static self afternoon()
 * @method static self dinner()
 **/
class MealType extends Enum
{
    protected static function values(): array
    {
        return [
            'breakfast' => 1,
            'lunch' => 2,
            'afternoon' => 3,
            'dinner' => 4,
        ];
    }
}
