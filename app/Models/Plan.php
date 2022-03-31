<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanAddon;
use Illuminate\Support\Str;
class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'name',
        'price',
        'duration_weeks',
        'stripe_price_id',
        'stripe_product_id',
        'image_number',
        'video_number'
    ];

    public function addons() {
        return $this->hasMany(PlanAddon::class, 'plan_id', 'id');
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

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
