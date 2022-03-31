<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Boat;
use App\Models\OrderTransaction;

class Order extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'boat_id',
        'order_date',
        'status',
        'payment_type',
        'stripe_customer_id',
        'stripe_payment_id',
        'order_total',
        'auto_renewal',
        'auto_renewal_discount'
    ];

    public function boat() 
    {
        return $this->belongsTo(Boat::class, 'boat_id', 'id');
    }

    public function orderTransactions()
    {
        return $this->belongsTo(OrderTransaction::class, 'id', 'boat_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

        self::creating(function ($model) {
            $model->invoice_id = rand(10000, 99999999);
        });
    }
}
