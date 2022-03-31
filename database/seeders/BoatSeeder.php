<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker;
use Carbon\Carbon;

class BoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $modelIds = \App\Models\BrandModel::select('id')
			->pluck('id')
			->toArray();
        $userIds = \App\Models\User::select('id')
            ->where('role', 'user')
			->pluck('id')
			->toArray();
        $planIds = \App\Models\Plan::select('id')
			->pluck('id')
			->toArray();
        $categoryIds = \App\Models\Category::select('id')
			->pluck('id')
			->toArray();
        $hullMaterials =  \App\Models\Option::select('name')
                        ->where('option_type', 'hull_material')
                        ->pluck('name')
                        ->toArray();
        $boatTypes = \App\Models\Option::select('id')
                    ->where('option_type', 'boat_type')
                    ->pluck('id')
                    ->toArray();
        $paymentStatusArray = ['paid', 'unpaid'];
        $boatConditions = ['New', 'Used', 'Salvage Title'];
        $engineTypes = ['electric', 'inboard', 'outboard', 'other'];
        $fuelTypes = ['diesel','electric','gasoline','lpg','other'];
        $paymentUnpaidStatus = ['pending', 'cancelled', 'failed'];
        $stripCustomerId = (string) Str::uuid();
        foreach($userIds as $userId){
            $termination = rand(20,40);
            for($i=1; $i<=$termination; $i++){
                $planId =  $planIds[array_rand($planIds)];
                $boatUuid = (string) Str::uuid();
                $categoriesId =  $categoryIds[array_rand($categoryIds)];
                $modelId =  $modelIds[array_rand($modelIds)];
                $user = \App\Models\User::where('id', $userId)->first();
                $model = \App\Models\BrandModel::where('id', $modelId)->first();
                $paymentStatus = $paymentStatusArray[array_rand($paymentStatusArray)];
                $totalOrder =  $faker->randomFloat($nbMaxDecimals = NULL, $min = 50, $max = 90);
                $boatName =  $faker->company;
                $boatYear =  $faker->year($max = 'now');
                $slugString = preg_replace('/[^A-Za-z0-9\-]/', ' ', $boatYear.' '.$model->brand->name.' '.$model->model_name.' '.$boatUuid);
                $boatSlug =  Str::slug($slugString, '-');
                $boat = \App\Models\Boat::create([
                    'user_id' => $userId,
                    'uuid' => $boatUuid,
                    'brand_id' => $model->brand_id,
                    'boat_type' => $boatTypes[array_rand($boatTypes)],
                    'boat_name' => $boatName,
                    'category_id' => $categoriesId ,
                    'hull_material' => $hullMaterials[array_rand($hullMaterials)],
                    'length' => rand(15, 26),
                    'model' => $model->model_name,
                    'year' => $boatYear,
                    'slug' => $boatSlug,
                    'price' =>$faker->randomNumber(4),
                    'price_currency' => $faker->currencyCode,
                    'country' => $user->country,
                    'state' => $user->state,
                    'zip_code' => $user->zip_code,
                    'general_description' => $model->brand->description,
                    // 'youtube_video' =>'https://youtu.be/9xwazD5SyVg',
                    'is_request_price' => rand(0,1),
                    'boat_condition' => $boatConditions[array_rand($boatConditions)],
                    'is_active' => 'Y',
                    'plan_id' => $planId,
                    'payment_status' => $paymentStatus
                ]);

                \App\Models\Engine::firstOrCreate([
                        'boat_id' => $boat->id,
                    ],
                    [
                        'uuid' => (string) Str::uuid(),
                        'engine_type' => $engineTypes[array_rand($engineTypes)],
                        'fuel_type' => $fuelTypes[array_rand($fuelTypes)],
                        'make' => $model->brand->name,
                        'model' => $model->model_name,
                        'horse_power' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 125, $max = 200),
                        'engine_hours' => rand(1,600),
                    ]
                );
                $cruisingSpeed = rand(3400,3800);
                $maxSpeed = rand($cruisingSpeed,3800);
                \App\Models\OtherInformation::firstOrCreate([
                    'boat_id' => $boat->id,
                    '12_digit_HIN' => $faker->numerify('###########'),
                    ],
                    [
                        'uuid' => (string) Str::uuid(),
                        'bridge_clearance' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 999),
                        'designer' => $model->brand->name,
                        'fuel_capacity' => rand(2,250), // Fuel capacity in gallon
                        'holding' => rand(10,36), // extra fuel storage in gallon
                        'fresh_water' => rand(3,180), // Fresh water holdings in gallon
                        'cruising_speed' => $cruisingSpeed,  // Cruising Speed in rpm
                        'LOA' =>  $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 75),
                        'tanks' => rand(0, 4), // Number of tanks
                        'max_speed' => $maxSpeed,
                        'beam_feet' =>  $faker->randomFloat($nbMaxDecimals = NULL, $min = 6.5, $max = 20)
                    ]);
                    $numberOfBoatImages = rand(2,5);
                for($boatCount=0; $boatCount< $numberOfBoatImages; $boatCount++){
                    $folderPath = 'public/storage/boats/'.$boat->uuid;
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0755, true);
                    }
                    $image = $faker->image($folderPath, 1120, 630, 'boats');
                    $image = str_replace ('public/', '', $image);
                    $image = str_replace ('\\', '/', $image);
                    $array = explode('.', $image);
                    $extension = end($array);
                    \App\Models\BoatImage::firstOrCreate([
                        'image_name' => $image,
                    ],
                    [
                            'boat_id' => $boat->id,
                            'uuid' => (string) Str::uuid(),
                            'image_type' => $extension
                    ]
                    );
                }
                $orderStatus = ($paymentStatus == 'paid') ? 'paid' : $paymentUnpaidStatus[array_rand($paymentUnpaidStatus)];
                $order = \App\Models\Order::firstOrCreate([
                    'stripe_payment_id' => (string) Str::uuid(),
                    ],
                    [
                        'uuid' => (string) Str::uuid(),
                        'user_id' => $user->id,
                        'boat_id' => $boat->id,
                        'order_date' => Carbon::now()->format('Y-m-d H:i:s'),
                        'status' => $orderStatus,
                        'payment_type' => 'stripe',
                        'stripe_customer_id' => $stripCustomerId,
                        'order_total' => $totalOrder,
                        'auto_renewal' => rand(0,1),
                        'auto_renewal_discount' => rand(1,10)
                    ]);
                    $order = \App\Models\OrderTransaction::firstOrCreate([
                        'order_id' => $order->id,
                        'transaction_id' => $faker->numerify('###########'),
                        'stripe_payment_id' => (string) Str::uuid(),
                        ],
                        [
                            'uuid' => (string) Str::uuid(),
                            'user_id' => $user->id,
                            'order_date' =>  Carbon::now()->format('Y-m-d H:i:s'),
                            'status' => $orderStatus,
                            'payment_type' => 'stripe',
                            'stripe_customer_id' => $stripCustomerId,
                            'order_total' => $totalOrder
                        ]);
            }
        }

    }
}
