<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\PlanRepositoryInterface;

use App\Models\Coupon;
use App\Models\Boat;
use App\Models\UserPlanAddon;
use Session;

class PlanController extends Controller
{
    private $planRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PlanRepositoryInterface $planRepository) {
        $this->planRepository = $planRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = $this->planRepository->get();
        $planId = config('yatchfindr.defaults.DEFAULT_PLAN_ID');
        $planAddOns = $this->planRepository->getAddOnsByPlanName($planId);
       // $planAddOns = $this->planRepository->getAllAddOns();
        return view('front.listings.select-plan', compact('plans', 'planAddOns'));
    }

    /**
     * get addons for selected plans AJAX.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPlanAddOns(Request $request, $uuid) 
    {
        $plan = $this->planRepository->getByUuid($uuid);
        if($plan) {
            $getAddOns = $this->planRepository->getPlanAddOns($plan->id);
            return response()->json([
                'status' => 'success',
                'addOns' => $getAddOns
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }
    }

    public function choosePlan(Request $request) 
    {

        // dd($request->all());

        $isCouponValid = ($request->is_coupon_valid == 'true') ? true : false;

        $filter = array_slice($request->all(), 1);

        unset($filter['is_coupon_valid']);
        unset($filter['default_coupon_selected']);
        unset($filter['default_addon_selected']);
        unset($filter['default_selected_plan']);
        $coupon = array_pop($filter);
        $planBasicInfo = array_splice($filter, 0, 2);
        
        $addons = $filter;
         
        $planBasicInfo['plan_uuid'] =  $request->plan_uuid;


        $plan = $this->planRepository->getByUuid($request->plan_uuid);

        if($plan) {
            $storePlanAddon = $this->planRepository->storeUserPlanAddon($planBasicInfo, $addons, $isCouponValid, $request->coupon_code);
            return redirect()->route('step-one');
        }
        else {
            return redirect()->back();
        }

    }

    public function verifyCoupon(Request $request, $code) {

        $user = Auth()->user();

        $coupon = Coupon::where('code', $code)->first();

        $boat = Boat::where('user_id', $user->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();

        if($boat) {
            $userPlanAddons = UserPlanAddon::where('user_id', $user->id)
                            ->where('boat_id', $boat->id)
                            ->get();
                            
            if(count($userPlanAddons) > 0) {
                UserPlanAddon::where('user_id', $user->id)
                                ->where('boat_id', $boat->id)
                                ->update(['coupon_id' => $coupon->id]);
            }
        }

        if($coupon) {
            return response()->json([
                'success' => true,
                'coupon' => $coupon
            ], 200);
        }else {
            return response()->json([
                'error' => true
            ], 422);
        }

    }

    public function removeCoupon(Request $request) {

        $user = Auth()->user();

        $boat = Boat::where('user_id', $user->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();
        try {

            if($boat) {
                UserPlanAddon::where('user_id', $user->id)
                            ->where('boat_id', $boat->id)
                            ->update(['coupon_id' => null]);
                 return response()->json([
                        'success' => true
                    ], 200); 
            }

           

        } catch(\Exception $e) {
            # Display error on client
            return response()->json([
                    'error' => true
            ], 422);
        }
    }

}
