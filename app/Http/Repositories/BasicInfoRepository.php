<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;

use App\Http\Interfaces\BasicInfoRepositoryInterface;

use App\Models\Boat;
use App\Models\Brand;
use App\Models\Option;
use App\Models\Category;
use App\Models\OtherInformation;

class BasicInfoRepository implements BasicInfoRepositoryInterface
{

	/**
     * Get record By User Id.
     * @param array basic info
     */
    public function getByUserId()
    {
    	try {
            return Boat::where('user_id', Auth()->user()->id)
                            ->where('plan_id', '!=', null)
                            ->where('payment_status', 'unpaid')
                            ->where('publish_status', 'draft')
                            ->where('is_active', 'N')
                            ->latest()
                            ->first();
    	} catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Get record By Boat Id.
     * @param array basic info
     */
    public function getByBoatUuid($boat_uuid)
    {
        try {
            return Boat::where('user_id', Auth()->user()->id)
                        ->where('uuid', $boat_uuid)
                        ->first();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getOption($uuid)
    {
        return Option::where('uuid', $uuid)->first();
    }

    /**
     * Create new Basic Info.
     * @param array basic info
     */
    public function store(array $basicInfoData)
    {


    	$brand = Brand::where('uuid', $basicInfoData['brand'])->first();
        $category = Category::where('uuid', $basicInfoData['category'])->first();
        // $boatType = $this->getOption($basicInfoData['boat_type']);

        $boat = Boat::where('user_id', Auth()->user()->id);
       
        if(!empty($basicInfoData['boat_uuid'])) {
            $boat = $boat->where('uuid', $basicInfoData['boat_uuid'])
                         ->where('payment_status', 'paid')
                         ->where('publish_status', 'published')
                         ->first();
        }else {
            $boat = $boat->where('payment_status', 'unpaid')
                         ->where('publish_status', 'draft')
                         ->where('is_active', 'N')
                         ->latest()->first();
        }

        $otherInformation = OtherInformation::where('boat_id', $boat->id)->latest()->first();
    	if(empty($boat)) {
    		$boat = new Boat;
    	}
        try {
            $boat->boat_type = $basicInfoData['boat_type'];
            $boat->category_id  = $category->id;
            $boat->boat_condition  = $basicInfoData['boat_condition'];
            $boat->year = $basicInfoData['year'];
            $boat->brand_id = $brand->id;
            $boat->model = $basicInfoData['brand_model'];
            $boat->length = $basicInfoData['length'];
            $boat->price = $basicInfoData['price'];
            $boat->price_currency = $basicInfoData['price_currency'];
            
            if($basicInfoData['price'] == 0) {
                $boat->is_request_price = 1;
            }
            $boat->save();
            //save slug
            $slugString = preg_replace('/[^A-Za-z0-9\-]/', ' ', $basicInfoData['year'].' '.$brand->name.' '.$basicInfoData['brand_model'].' '.$boat->uuid);
            $boatSlug =  Str::slug($slugString, '-');
            $boat->slug = $boatSlug;
            $boat->save();

            if(empty($otherInformation)) {
                $otherInformation = new OtherInformation;
            }
            $otherInformation->boat_id = $boat->id;
            $otherInformation->beam_feet = $basicInfoData['beam'];
            $otherInformation->draft = $basicInfoData['draft'];
            $otherInformation->bridge_clearance = $basicInfoData['bridge_clearance'];
            $otherInformation->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
