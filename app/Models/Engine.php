<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Engine extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'boat_id',
        'engine_type',
        'fuel_type',
        'make',
        'model',
        'horse_power',
        'engine_hours'

    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($engine) {
            $engine->uuid = (string) Str::uuid();
        });
    }
}
