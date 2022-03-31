<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country;

class State extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'country',
        'state',
        'name',
        'timezone'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'code', 'country');
    }
}
