<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [''];

    protected $table = "foods";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
