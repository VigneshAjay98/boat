<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtherInformation extends Model
{
    use HasFactory;
    protected $table = 'other_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'boat_id',
        '12_digit_HIN',
        'bridge_clearance',
        'designer',
        'full_capacity',
        'holding',
        'fresh_water',
        'cruising_speed',
        'LOA',
        'tanks',
        'max_speed',
        'beam_feet',
        'accomodations',
        'mechanical_equipment',
        'galley_equipment',
        'deck_hull_equipment',
        'navigation_systems',
        'additional_equipment',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($otherInformation) {
            $otherInformation->uuid = (string) Str::uuid();
        });
    }
}
