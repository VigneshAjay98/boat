<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public $timestamps = false;
     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        's_order',
        'region',
        'selector',
        'ship_modes',
        'name',
        'iso',
        'iso_number',
        'tax'
    ];

    public function states()
    {
        return $this->hasMany(State::class, 'country', 'code');
    }
}
