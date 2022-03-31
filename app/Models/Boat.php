<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Rennokki\QueryCache\Traits\QueryCacheable;
use EloquentFilter\Filterable;
use PhpParser\Node\Expr\Isset_;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\UserPlanAddon;
use App\Models\FavoriteBoat;
use App\Models\BlockedBoat;
use App\Models\ExcludedBoat;
class Boat extends Model
{
    use HasFactory;
    use Filterable;
    public static $currencyRates;
    // use QueryCacheable;
    // protected $cacheFor = 180; // 3 minutes
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'brand_id',
        'boat_type',
        'category_id',
        'hull_material',
        'length',
        'model',
        'boat_name',
        'year',
        'slug',
        'price',
        'price_currency',
        'country',
        'state',
        'zip_code',
        'general_description',
        'is_request_price',
        'boat_condition',
        'status',
        'plan_id',
        'accomodations',
        'mechanical_equipment',
        'galley_equipment',
        'deck_hull_equipment',
        'navigation_systems',
        'additional_equipment',
        'payment_status'
    ];


    public function getCurrencySymbolAttribute(){
        $currency = session('USER_CURRENCY') ?? 'USD';// get session value
        // $currency = $this->price_currency;
        $locale='en-US'; //browser or user locale
        $fmt = new \NumberFormatter( $locale."@currency=$currency", \NumberFormatter::CURRENCY );
        $symbol = $fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        return $symbol;
    }

    public function getPriceAttribute($value){
        $currency = $this->price_currency;
        $userCurrency = $currency = session('USER_CURRENCY')??'USD';
        // $currency = 'INR';
        $ratesObject = self::$currencyRates;
        $conversionValue = $ratesObject->rates->{$userCurrency};
        // if($currency == 'USD'){
        //     return $value;
        // }
        // else{
            return $value * $conversionValue;
        // }
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function favorite()
    {
        return $this->belongsTo(FavoriteBoat::class, 'id', 'boat_id');
    }

    public function userPlanAddons()
    {
        return $this->hasMany(UserPlanAddon::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'boat_id');
    }

    public function modelFilter()
    {
        return $this->provideFilter(\App\ModelFilters\BoatFilter::class);
    }


    public function boatInfo()
    {
        return $this->belongsTo(OtherInformation::class, 'id', 'boat_id');
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'id', 'boat_id');
    }

    public function images()
    {
        return $this->hasMany(BoatImage::class);
    }

    public function videos()
    {
        return $this->hasMany(BoatVideo::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'boat_type', 'boat_type');
    }

    public function brandModels()
    {
        return $this->hasMany(BrandModel::class, 'brand_id', 'brand_id');
    }

    public function engines()
    {
        return $this->hasMany(Engine::class, 'boat_id', 'id');
    }

    public function otherInformation()
    {
        return $this->hasOne(OtherInformation::class, 'boat_id', 'id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }

    public function excluded() {
        return $this->hasOne(ExcludedBoat::class, 'boat_id', 'id');
    }

    public function scopeUnblockedBoats($query)
	{
        if(Auth::check()) {
            $boatIds = \App\Models\BlockedBoat::select('boat_id')
                        ->where('user_id', Auth::id())
                        ->pluck('boat_id')
                        ->toArray();
            return $query->whereNotIn('id', $boatIds);
        }
        return $query;
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

        self::$currencyRates = self::getRates();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

    }

    protected static function getRates(){
        $req_url = 'https://api.exchangerate.host/latest?base=USD';
        $response_json = file_get_contents($req_url);

        if(false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if($response->success === true) {
                    return  $response;
                }
            } catch(Exception $e) {
                // Handle JSON parse error...
            }
        }
    }

}
