<?php

namespace App\Http\Controllers;
use Carbon\Carbon;


use App\Http\Interfaces\BoatRepositoryInterface;
use App\Http\Interfaces\BoatLocationRepositoryInterface;
use App\Http\Interfaces\PlanRepositoryInterface;
use App\Notifications\Invoice;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;

use App\Models\Boat;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\UserPlanAddon;
use App\Models\Coupon;
use Notification;
use Session;
use Auth;

class OrderController extends Controller
{
    private $boatRepository;
    private $locationRepository;
    private $planRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BoatRepositoryInterface $boatRepository, 
        BoatLocationRepositoryInterface $locationRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->boatRepository = $boatRepository;
        $this->locationRepository = $locationRepository;
        $this->planRepository = $planRepository;
    }

    public function testPayment(){
        $json = '{
              "object": {
                "id": "sub_1KBuqMCyFtddwrS8KLn8HkOV",
                "object": "subscription",
                "application_fee_percent": null,
                "automatic_tax": {
                  "enabled": false
                },
                "billing_cycle_anchor": 1640756218,
                "billing_thresholds": null,
                "cancel_at": null,
                "cancel_at_period_end": false,
                "canceled_at": null,
                "collection_method": "charge_automatically",
                "created": 1640756218,
                "current_period_end": 1648013818,
                "current_period_start": 1640756218,
                "customer": "cus_Kre8Pbk11xadBw",
                "days_until_due": null,
                "default_payment_method": "pm_1KBupxCyFtddwrS89qklF1mi",
                "default_source": null,
                "default_tax_rates": [
                ],
                "discount": null,
                "ended_at": null,
                "items": {
                  "object": "list",
                  "data": [
                    {
                      "id": "si_Kre8t9nQs9bOlT",
                      "object": "subscription_item",
                      "billing_thresholds": null,
                      "created": 1640756219,
                      "metadata": {
                      },
                      "plan": {
                        "id": "price_1KBucHCyFtddwrS8FZqkAT4I",
                        "object": "plan",
                        "active": true,
                        "aggregate_usage": null,
                        "amount": 2000,
                        "amount_decimal": "2000",
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "interval": "week",
                        "interval_count": 12,
                        "livemode": false,
                        "metadata": {
                        },
                        "nickname": "Facebook Marketplace",
                        "product": "prod_KrdutLUyxZEJl5",
                        "tiers_mode": null,
                        "transform_usage": null,
                        "trial_period_days": null,
                        "usage_type": "licensed"
                      },
                      "price": {
                        "id": "price_1KBucHCyFtddwrS8FZqkAT4I",
                        "object": "price",
                        "active": true,
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "livemode": false,
                        "lookup_key": null,
                        "metadata": {
                        },
                        "nickname": "Facebook Marketplace",
                        "product": "prod_KrdutLUyxZEJl5",
                        "recurring": {
                          "aggregate_usage": null,
                          "interval": "week",
                          "interval_count": 12,
                          "trial_period_days": null,
                          "usage_type": "licensed"
                        },
                        "tax_behavior": "unspecified",
                        "tiers_mode": null,
                        "transform_quantity": null,
                        "type": "recurring",
                        "unit_amount": 2000,
                        "unit_amount_decimal": "2000"
                      },
                      "quantity": 1,
                      "subscription": "sub_1KBuqMCyFtddwrS8KLn8HkOV",
                      "tax_rates": [
                      ]
                    },
                    {
                      "id": "si_Kre8WEsAuoD7VI",
                      "object": "subscription_item",
                      "billing_thresholds": null,
                      "created": 1640756219,
                      "metadata": {
                      },
                      "plan": {
                        "id": "price_1KBucHCyFtddwrS8MdYJZhIz",
                        "object": "plan",
                        "active": true,
                        "aggregate_usage": null,
                        "amount": 1500,
                        "amount_decimal": "1500",
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "interval": "week",
                        "interval_count": 12,
                        "livemode": false,
                        "metadata": {
                        },
                        "nickname": "Instagram posts",
                        "product": "prod_KrdutLUyxZEJl5",
                        "tiers_mode": null,
                        "transform_usage": null,
                        "trial_period_days": null,
                        "usage_type": "licensed"
                      },
                      "price": {
                        "id": "price_1KBucHCyFtddwrS8MdYJZhIz",
                        "object": "price",
                        "active": true,
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "livemode": false,
                        "lookup_key": null,
                        "metadata": {
                        },
                        "nickname": "Instagram posts",
                        "product": "prod_KrdutLUyxZEJl5",
                        "recurring": {
                          "aggregate_usage": null,
                          "interval": "week",
                          "interval_count": 12,
                          "trial_period_days": null,
                          "usage_type": "licensed"
                        },
                        "tax_behavior": "unspecified",
                        "tiers_mode": null,
                        "transform_quantity": null,
                        "type": "recurring",
                        "unit_amount": 1500,
                        "unit_amount_decimal": "1500"
                      },
                      "quantity": 1,
                      "subscription": "sub_1KBuqMCyFtddwrS8KLn8HkOV",
                      "tax_rates": [
                      ]
                    },
                    {
                      "id": "si_Kre8AUAslowple",
                      "object": "subscription_item",
                      "billing_thresholds": null,
                      "created": 1640756219,
                      "metadata": {
                      },
                      "plan": {
                        "id": "price_1KBucHCyFtddwrS8SCjNN5eQ",
                        "object": "plan",
                        "active": true,
                        "aggregate_usage": null,
                        "amount": 12000,
                        "amount_decimal": "12000",
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "interval": "week",
                        "interval_count": 12,
                        "livemode": false,
                        "metadata": {
                        },
                        "nickname": "Premium",
                        "product": "prod_KrdutLUyxZEJl5",
                        "tiers_mode": null,
                        "transform_usage": null,
                        "trial_period_days": null,
                        "usage_type": "licensed"
                      },
                      "price": {
                        "id": "price_1KBucHCyFtddwrS8SCjNN5eQ",
                        "object": "price",
                        "active": true,
                        "billing_scheme": "per_unit",
                        "created": 1640755345,
                        "currency": "usd",
                        "livemode": false,
                        "lookup_key": null,
                        "metadata": {
                        },
                        "nickname": "Premium",
                        "product": "prod_KrdutLUyxZEJl5",
                        "recurring": {
                          "aggregate_usage": null,
                          "interval": "week",
                          "interval_count": 12,
                          "trial_period_days": null,
                          "usage_type": "licensed"
                        },
                        "tax_behavior": "unspecified",
                        "tiers_mode": null,
                        "transform_quantity": null,
                        "type": "recurring",
                        "unit_amount": 12000,
                        "unit_amount_decimal": "12000"
                      },
                      "quantity": 1,
                      "subscription": "sub_1KBuqMCyFtddwrS8KLn8HkOV",
                      "tax_rates": [
                      ]
                    }
                  ],
                  "has_more": false,
                  "total_count": 3,
                  "url": "/v1/subscription_items?subscription=sub_1KBuqMCyFtddwrS8KLn8HkOV"
                },
                "latest_invoice": "in_1KBuqMCyFtddwrS8AkuFjugv",
                "livemode": false,
                "metadata": {
                },
                "next_pending_invoice_item_invoice": null,
                "pause_collection": null,
                "payment_settings": {
                  "payment_method_options": null,
                  "payment_method_types": null
                },
                "pending_invoice_item_interval": null,
                "pending_setup_intent": null,
                "pending_update": null,
                "plan": null,
                "quantity": null,
                "schedule": null,
                "start_date": 1640756218,
                "status": "active",
                "transfer_data": null,
                "trial_end": null,
                "trial_start": null
              }
            }';
        $subscriptionObject  = json_decode($json, true);
        $user = Auth::user();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);

        //save the order
        $boat = Boat::where('user_id', $user->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();

        $addons = $this->planRepository->getPackageAddOns($boat->id, $boat->plan_id);

        try {

            $order = new Order;
            $order->user_id = $user->id;
            $order->boat_id = $boat->id;
            $order->order_date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $order->status = 'paid';
            $order->payment_type = 'stripe';
            $order->stripe_customer_id = $request->customer_id;
            $order->stripe_payment_id = $request->payment_method_id;
            $order->order_total = $request->order_total;
            $order->auto_renewal = $autoRenewal;
            $order->auto_renewal_discount = 25;
            $order->save();

            $orderTransaction = new OrderTransaction;
            $orderTransaction->order_id = $order->id;
            $orderTransaction->user_id = $user->id;
            $orderTransaction->order_date = $order->order_date;
            $orderTransaction->status = $order->status;
            $orderTransaction->payment_type = $order->payment_type;
            // $orderTransaction->transaction_id = '';
            $orderTransaction->stripe_customer_id = $order->stripe_customer_id;
            $orderTransaction->stripe_payment_id = $order->stripe_payment_id;
            $orderTransaction->order_total = $order->order_total;
            $orderTransaction->save();

            $this->boatRepository->saveUserBoat();

            $orderDetails = [
                'order_id' => $order->invoice_id,
                'order_date' => $orderTransaction->order_date,
                'order_total' => $orderTransaction->order_total,
                'status' => $orderTransaction->status,
                'plan' => $boat->plan->name,
                'duration' => $boat->plan->duration_weeks,
                'addons' => $addons,
                'auto_renew' => $autoRenewal
            ];

            /*Send invoice*/
            Notification::route('mail', $request->email)
                        ->notify(new Invoice($orderDetails, $user));

            return response()->json([
                'success' => true
            ]); 
        } catch (\Exception $e) {
            # Display error on client
            $this->error('Payment Success but failed to create listing')->push();
            return response()->json([
                    'error' => 'Payment Success but failed to create listing',
            ], 500);
        }
    }

    /*SAVE & EXIT Step-five*/
    public function storeStepFive(Request $request) 
    {
        
        $subscriptionId = null;
        $boat = $this->boatRepository->saveUserBoat($subscriptionId);

        if($boat) {
            $this->success('Yacht Saved Successfully!')->push();
            return redirect()->route('my-yachts');
        }else {
            return redirect()->route('step-five');
        }
    }

    public function processPayment(Request $request)
    {

       
        $boat = Boat::where('user_id', Auth()->user()->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();

        $userCoupon = '';
        if($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();

            if($coupon) {
                $userCoupon = $coupon;
            }
        }

        $user = Auth::user();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);

        $autoRenewal = ($request->auto_renewal == 'on') ? true : false ;
        
        $options = [
            'name' => $user->full_name,
            'email' => $user->email,
            'address' =>[
                'line1' => $request->billing_address,
                'country' => "US",
            ],
            'description' => $boat->slug.' subscription'
        ];

        if(!$user->stripe_id){
            $stripeCustomer = $user->createAsStripeCustomer($options);
        }
        else{
            $stripeCustomer = $user->createOrGetStripeCustomer();
        }

        $intent = null;
        try {

            if (isset($request->payment_method)) {

                $user->addPaymentMethod($request->payment_method);

                    //get user all addons
                    $userPlanAddon = $this->planRepository->getPackageAddOns($boat->id, $boat->plan_id);
                    $subscriptionItems = [];
                    $StripePriceId = [];
                    if($userPlanAddon && count($userPlanAddon) > 0 ){

                        foreach($userPlanAddon as $userPlan){
                            $subscriptionItems[] = [
                                'price' => $userPlan->stripe_price_id
                            ];
                            $StripePriceId[]  =$userPlan->stripe_price_id;
                        }
                    }
                    //add plan price to subscriptionItems
                    $subscriptionItems[] = [ 'price' => $boat->plan->stripe_price_id];
                    $StripePriceId[]  = $boat->plan->stripe_price_id;

                    $subscriptionName = 'Yacht-Subscription-'.$boat->uuid;
                    
                    if($autoRenewal == false){
                        $weekDuration = $boat->plan->duration_weeks;
                        $newSubscription = $user->newSubscription($subscriptionName, $StripePriceId)->create($request->payment_method);
                        //go ahead and set cancel date
                        $user->subscription($subscriptionName)->cancelAt(Carbon::now()->addWeeks($weekDuration));
                    }
                    else{
                        $newSubscription = $user->newSubscription($subscriptionName, $StripePriceId);
                        if(!empty($userCoupon)){
                            $newSubscription = $newSubscription->withCoupon($userCoupon->stripe_coupon_id);    
                        }
                        $newSubscription  = $newSubscription->create($request->payment_method);    
                    }
                    $this->boatRepository->saveUserBoat($newSubscription->id);
                    /*Send invoice*/
                    // Notification::route('mail', $request->email)->notify(new Invoice($orderDetails, $user));

                    //here we need to enable boat status
                    return redirect('/payment-success');

            }//if (isset($request->payment_method)) {
           
        } catch (\Exception $e) {
            return redirect('/listing/step-five')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function confirmPayment(Request $request){

        $user = Auth::user();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);

        $stripeCustomer = $user->createOrGetStripeCustomer();     

        $autoRenewal = ($request->auto_renewal == 'true') ? 1 : 0 ;

        if($autoRenewal == 1) {

            /*Creating Discount coupon*/
            $coupon = $stripe->coupons->create([
                        'name' => '25% off',
                        'percent_off' => 25,
                        'duration' => 'forever',
                        'applies_to' => [
                            'products' => [
                                Session::get('subscription')['product_id']
                            ]
                        ]
                    ]);

            $addDiscount = $stripe->subscriptionSchedules->create([
                        'customer' => $stripeCustomer->id,
                        'end_behavior' => 'cancel',
                        'start_date' => Session::get('subscription')['period_end'] + 1,
                        'end_behavior' => 'release',
                        'phases' => [
                            [
                                'items' => [
                                    [
                                      'price' => Session::get('subscription')['price_id'],
                                      'quantity' => 1,
                                    ],
                                ],
                                'coupon' => $coupon->id
                            ]
                        ],
                    ]);

            print_r($coupon);
            print_r($addDiscount); exit;

        }   

        $boat = Boat::where('user_id', $user->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();

        $addons = $this->planRepository->getPackageAddOns($boat->id, $boat->plan_id);

        try {

            $order = new Order;
            $order->user_id = $user->id;
            $order->boat_id = $boat->id;
            $order->order_date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $order->status = 'paid';
            $order->payment_type = 'stripe';
            $order->stripe_customer_id = $request->customer_id;
            $order->stripe_payment_id = $request->payment_method_id;
            $order->order_total = $request->order_total;
            $order->auto_renewal = $autoRenewal;
            $order->auto_renewal_discount = 25;
            $order->save();

            $orderTransaction = new OrderTransaction;
            $orderTransaction->order_id = $order->id;
            $orderTransaction->user_id = $user->id;
            $orderTransaction->order_date = $order->order_date;
            $orderTransaction->status = $order->status;
            $orderTransaction->payment_type = $order->payment_type;
            // $orderTransaction->transaction_id = '';
            $orderTransaction->stripe_customer_id = $order->stripe_customer_id;
            $orderTransaction->stripe_payment_id = $order->stripe_payment_id;
            $orderTransaction->order_total = $order->order_total;
            $orderTransaction->save();

            $this->boatRepository->saveUserBoat();

            $orderDetails = [
                'order_id' => $order->invoice_id,
                'order_date' => $orderTransaction->order_date,
                'order_total' => $orderTransaction->order_total,
                'status' => $orderTransaction->status,
                'plan' => $boat->plan->name,
                'duration' => $boat->plan->duration_weeks,
                'addons' => $addons,
                'auto_renew' => $autoRenewal
            ];

            /*Send invoice*/
            Notification::route('mail', $request->email)
                        ->notify(new Invoice($orderDetails, $user));

            return response()->json([
                'success' => true
            ]); 
        } catch (\Exception $e) {
            # Display error on client
            $this->error('Payment Success but failed to create listing')->push();
            return response()->json([
                    'error' => 'Payment Success but failed to create listing',
            ], 500);
        }
    }

    public function paymentSuccess() {
        return view('front.listings.payment-success');
    }

    /*Cancel Subscription*/
    public function cancelSubscription(Request $request, $subscriptionName) {
        $user = Auth::user();
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);

        $user->subscription($subscriptionName)->cancel();

        return response()->json([
            'success' => true,
            'message' => 'Your subscription is canceled successfully!'
        ], 200);
    }

}
