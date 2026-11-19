<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnalogTape extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'media_format',
        'recording_year',
    ];

    public function condition(): HasOne
    {
        return $this->hasOne(TapeCondition::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(RestorationAction::class);
    }
}
