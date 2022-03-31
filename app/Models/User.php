<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Support\Str;

use App\Models\Country;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Billable;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'email',
        'password',
        'contact_number',
        'first_name',
        'last_name',
        'image',
        'address',
        'city',
        'country',
        'state',
        'zip_code',
        'email_verified_at',
        'role',
        'is_request_price',
        'stripe_customer_id',
        'stripe_payment_token',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute($value)
    {
        return (ucfirst($this->first_name) ?? '') . ' ' . (ucfirst($this->last_name) ?? '');
    }

    public function getShortFullNameAttribute($value)
    {
        return (((isset($this->first_name)) ? ucfirst($this->first_name[0] ?? '') : '').((isset($this->last_name)) ? ucfirst($this->last_name[0] ?? '') : ''));
    }

    public function getFirstUserNameAttribute($value)
    {
        return ucfirst($this->first_name) ?? '';
    }

    public function getLastUserNameAttribute($value)
    {
        return ucfirst($this->last_name) ?? '';
    }

    public function scopeByUuid($query, $uuId)
    {
        return $query->whereUuid($uuId);
    }

    public function getCountry()
    {
        return $this->belongsTo(Country::class, 'country', 'name');
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


    public function isAdmin() {
       return $this->role === 'admin';
    }

    public function isUser() {
       return $this->role === 'user';
    }


}
