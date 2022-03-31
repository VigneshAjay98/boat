<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Stripe\Stripe;

use App\Models\Plan;
use App\Models\PlanAddon;



class StripePlanProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->addPlans();
        return 0;
    }

    public function addPlans(){
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);

        $plans = Plan::all();
        foreach($plans as $plan){
           

            $options = [
                'name' => $plan->name,
                'description' => 'YachtFindr-'.$plan->name
            ];


            $productObject  = $stripe->products->create($options);


            $priceOptions = [
                'currency' => 'usd',
                'product' => $productObject->id,
                'unit_amount' => ($plan->price) * 100,
                'nickname' => $plan->name,
                'recurring' => [
                    'interval' => 'week',
                    'interval_count' => $plan->duration_weeks,
                ]

            ];

            $plansProductPrice = $stripe->prices->create($priceOptions);
            $plan->stripe_price_id = $plansProductPrice->id;
            $plan->stripe_product_id = $productObject->id;
            $plan->save();
            $addOns = PlanAddon::where('plan_id', $plan->id)->get();

            foreach($addOns as $addon){
                $options = [
                    'currency' => 'usd',
                    'product' => $productObject->id,
                    'unit_amount' => $addon->addon_cost *100,
                    'nickname' => $addon->addon_name,
                    'recurring' => [
                        'interval' => 'week',
                        'interval_count' => $plan->duration_weeks,
                    ]
                ];
                $addStripePrice = $stripe->prices->create($options);
                $addon->stripe_price_id = $addStripePrice->id;
                $addon->save();
            }
        }
    }


       
}
