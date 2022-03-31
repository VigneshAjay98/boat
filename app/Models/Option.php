<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Models\Category;
use App\Models\ActivityCategory;

class Option extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'uuid',
        'name',
        'option_type',
        'slug',
        'status'
    ];


    public function categories() {
        return $this->hasMany(Category::class, 'boat_type', 'id');
    }

    public function activities() {
        return $this->hasMany(ActivityCategory::class, 'option_id', 'id');
    }

    public function scopeByUuid($query, $uuId)
    {
        return $query->whereUuid($uuId);
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

     /**
	 * Scope a query active column
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeIsActive($query)
	{
		return $query->where('is_active', 'Y');
	}
}
