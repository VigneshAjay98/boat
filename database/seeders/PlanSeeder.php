<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            ['name' => 'Premium', 'price' => 120, 'duration_weeks'=> 12, 'image_number' => null, 'video_number' => null],
            ['name' => 'Enhanced', 'price' => 85, 'duration_weeks'=> 6, 'image_number' => 5, 'video_number' => 5],
            ['name' => 'Basic', 'price' => 30, 'duration_weeks'=> 2, 'image_number' => 1, 'video_number' => 1]
        ];

        $addons = [
            ['addon_name' => 'Facebook Marketplace', 'addon_cost' => '20'],
            ['addon_name' => 'Instagram posts', 'addon_cost' => '15']
        ];

        if (!empty($plans)) {
            foreach($plans as $plan){
                $newPlan = \App\Models\Plan::firstOrCreate(
                    ['name' => $plan['name']],
                    [
                        'price' => $plan['price'],
                        'duration_weeks' => $plan['duration_weeks'],
                        'image_number' => $plan['image_number'],
                        'video_number' => $plan['video_number']
                    ]
                );

                if (!empty($addons)) {
                    foreach($addons as $addon) {
                        $addon = \App\Models\PlanAddon::firstOrCreate(
                            [
                                'addon_name' => $addon['addon_name'],
                                'plan_id' => $newPlan->id
                            ],
                            [
                                'addon_cost' => $addon['addon_cost']
                            ]
                        );
                    }
                }
            }
        }
    }
}
