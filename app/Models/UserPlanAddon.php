<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Plan;
use App\Models\PlanAddon;
use App\Models\Boat;

class UserPlanAddon extends Model
{
    use HasFactory;

    protected $table='user_plan_addons';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'boat_id',
        'plan_id',
        'addon_id'
    ];

    public function scopeByUuid($query, $uuId)
    {
        return $query->whereUuid($uuId);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($userPlanAddon) {
            $userPlanAddon->uuid = (string) Str::uuid();
        });
    }
}
