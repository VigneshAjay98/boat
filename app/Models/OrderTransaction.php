<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'order_id',
        'user_id',
        'order_date',
        'status',
        'payment_type',
        'transaction_id',
        'stripe_customer_id',
        'stripe_payment_id',
        'order_total'
    ];

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
