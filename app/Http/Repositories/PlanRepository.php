<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\PlanRepositoryInterface;

use App\Models\Plan;
use App\Models\PlanAddon;
use App\Models\UserPlanAddon;
use App\Models\Coupon;
use App\Models\Boat;
use App\Models\BoatImage;
use App\Models\BoatVideo;

class PlanRepository implements PlanRepositoryInterface
{
    /**
     * get a Plan
     * @param string
     * @return collection
     */
    public function get()
    {
        return Plan::all();
    }

    public function getPlan($boatId) {
        $plan_addons = UserPlanAddon::where('user_id', Auth()->user()->id)->where('boat_id', $boatId)->get();
        if(count($plan_addons) > 0) {
            return true;
        }else { 
            return false;
        }
    }

    public function getAddOnByUuid($uuid) 
    {
        return PlanAddon::where('uuid', $uuid)->first();
    }

    public function getAllAddOns() 
    {
        return PlanAddon::all();
    }
    public function getAddOnsByPlanName($planId) 
    {
        return PlanAddon::where('plan_id', $planId)->get();
    }
    public function getPlanAddOns($planId) 
    {
        return PlanAddon::where('plan_id', $planId)->get();
    }

    /**
     * get a Plan by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return Plan::where('uuid',$uuid)->first();
    }

    /**
     * Get a plan by it's slug
     *
     * @param int
     */
    public function getBySlug($slug)
    {
        return Plan::where('slug',$slug)->first();
    }

    /**
     * Get record By Plan Id.
     * @param array basic info
     */
    public function getPackageAddOns($boatId, $planId) 
    {
        try {
            $planaddons = UserPlanAddon::where('user_id', Auth()->user()->id)->where('boat_id', $boatId)->where('plan_id', $planId)->get();

            if(count($planaddons) > 0) {
                $ids = [];
                foreach($planaddons as $addOn) {
                    array_push($ids, $addOn->addon_id);
                }
                return PlanAddon::whereIn('id', $ids)->get();
            }else {
                return false;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }


    public function storeUserPlanAddon(array $planBasicData, array $addonData, $isValidCoupon, $couponCode) 
    {

        $userId = Auth()->user()->id;

        $plan = Plan::where('uuid', $planBasicData['plan_uuid'])->first();

        $boat = Boat::where('user_id', $userId)->where('payment_status', 'unpaid')->where('publish_status', 'draft')->latest()->first();

        if(!$boat) {
            $boat = new Boat;
            $boat->user_id = $userId;
        }
        $boat->plan_id = $plan->id;
        $boat->is_active = 'N';
        $boat->publish_status = 'draft';
        $boat->save();

        if($boat) {
            $checkPlanAddon = UserPlanAddon::where('user_id', $userId)->where('boat_id', $boat->id)->get();
            $checkImages = BoatImage::where('boat_id', $boat->id)->orderBy('id', 'DESC')->get();
            $checkVideos = BoatVideo::where('boat_id', $boat->id)->orderBy('id', 'DESC')->get();

            /*Delete previous selected plan*/
            if(count($checkPlanAddon) > 0) {
                foreach($checkPlanAddon as $checked) {
                    $checked->delete();
                }
            }

            if($boat->plan->name != 'Premium'){

                /*Delete additional images from previous plan selection */
                if(count($checkImages) > 0) {
                    $oldImagesCount = count($checkImages);
                    $imagesDifference = abs($oldImagesCount - $boat->plan->image_number);

                    if($oldImagesCount > $boat->plan->image_number) {
                        foreach($checkImages as $key => $imageChecked) {
                            if($key < $imagesDifference) {
                                $imageChecked->delete();
                            }
                        }
                    }
                }

            }

            if(!empty($boat->plan->video_number)) {

                /*Delete additional videos from previous plan selection */
                if(count($checkVideos) > 0) {
                    $oldVideosCount = count($checkVideos);
                    $videosDifference = abs($oldVideosCount - $boat->plan->video_number);

                    if($oldVideosCount > $boat->plan->video_number) {
                        foreach($checkVideos as $key => $videoChecked) {
                            if($key < $videosDifference) {
                                $videoChecked->delete();
                            }
                        }
                    }
                }
                
            }

        }

        $couponId = null;
        if($isValidCoupon) {
            $couponId = Coupon::where('code', $couponCode)->first()->id;
        }

        if(!empty($addonData)) {
            $getAddon = PlanAddon::query();
            foreach($addonData as $addon) {
                $getAddon = $getAddon->where('uuid', $addon)->first();

                $userPlanAddon = new UserPlanAddon;
                $userPlanAddon->user_id = $userId;
                $userPlanAddon->boat_id = $boat->id;
                $userPlanAddon->plan_id = $plan->id;
                $userPlanAddon->addon_id = $getAddon->id;
                $userPlanAddon->coupon_id = $couponId;
                $userPlanAddon->save();
            }
        } else {
            $userPlanAddon = new UserPlanAddon;
            $userPlanAddon->user_id = $userId;
            $userPlanAddon->boat_id = $boat->id;
            $userPlanAddon->plan_id = $plan->id;
            $userPlanAddon->coupon_id    = $couponId;
            $userPlanAddon->save();
        }

    }   

}
