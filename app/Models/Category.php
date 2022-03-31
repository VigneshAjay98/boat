<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use Illuminate\Support\Str;

use App\Models\Option;
use App\Models\Boat;

class Category extends Model
{
    use HasFactory;
    use HasSlug;
  /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'boat_type',
        'name',
        'slug',
        'description',
        'other_info',
        'is_active',
    ];


    public function option() {
        return $this->belongsTo(Option::class, 'boat_type', 'name');
    }

    public function activities()
    {
        return $this->hasOne(ActivityCategory::class, 'category_id', 'id');
    }

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }

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


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

        static::deleting(function ($category) {
            //remove related rows item
            $category->activities()->delete();
        });
    }
}
