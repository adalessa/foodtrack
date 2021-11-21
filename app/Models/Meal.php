<?php

namespace App\Models;

use App\Enums\MealType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $casts = [
        'date' => 'date',
    ];

    public function scopeRange($query, $from, $to)
    {
        return $query->whereBetween('date', [$from, $to]);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeAttribute($value)
    {
        return MealType::from($value);
    }

    public function setTypeAttribute(MealType $type)
    {
        $this->attributes['type'] = $type->value;
    }
}
