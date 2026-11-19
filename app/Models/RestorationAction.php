<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestorationAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'analog_tape_id',
        'action_name',
        'priority',
        'status',
    ];

    public function tape(): BelongsTo
    {
        return $this->belongsTo(AnalogTape::class, 'analog_tape_id');
    }
}
