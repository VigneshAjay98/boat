<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\SecondDetailsRepositoryInterface;

use App\Models\Boat;
use App\Models\OtherInformation;
use App\Models\Engine;
use App\Models\Plan;
use App\Models\Country;
use App\Models\State;

class SecondDetailsRepository implements SecondDetailsRepositoryInterface
{
    
    /**
     * Get record By Session Id.
     * @param array basic info
     */
    public function getEngine()
    {
        try {
            $boat = Boat::where('user_id', Auth()->user()->id)->where('payment_status', 'unpaid')->where('is_active', 'N')->latest()->first();
            if($boat) {
                $engines = Engine::where('boat_id', $boat->id)->get();
                if(count($engines) > 0) {
                    return true;
                }
            }else {
                return false;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getAllCountries() 
    {
        try {
            return Country::orderBy('name')->get();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getByCountry($country) 
    {   
        try {
            $country = Country::where('name', $country)->first();
            return State::where('country', $country->code)->orderBy('name')->get();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Create new Basic Info.
     * @param array basic info
     */
    public function store(array $secondDetailsData)
    {
        try
        {
            $boat = Boat::where('user_id', Auth()->user()->id);
            if(!empty($secondDetailsData['boat_uuid'])) {
                $boat = $boat->where('uuid', $secondDetailsData['boat_uuid'])
                             // ->where('payment_status', 'paid')
                             ->first();
            }else {
                $boat = $boat->where('payment_status', 'unpaid')
                             ->where('is_active', 'N')
                             ->latest()->first();
            }

            if(!empty($boat)) {
                $boat->general_description = $secondDetailsData['general_description'];
                $boat->save();

                $otherInformation = OtherInformation::where('boat_id', $boat->id)->latest()->first();
                if(empty($otherInformation)){
                    $otherInformation = new OtherInformation;
                    $otherInformation->boat_id = $boat->id;
                }
                $otherInformation->mechanical_equipment = $secondDetailsData['mechanical_equipment'];
                $otherInformation->deck_hull_equipment = $secondDetailsData['deck_hull_equipment'];
                $otherInformation->navigation_systems = $secondDetailsData['navigation_systems'];
                $otherInformation->additional_equipment = $secondDetailsData['additional_equipment'];
                $otherInformation->save();
            }
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
