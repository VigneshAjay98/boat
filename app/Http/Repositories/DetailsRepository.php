<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\DetailsRepositoryInterface;

use App\Models\Category;
use App\Models\Engine;
use App\Models\OtherInformation;
use App\Models\Option;
use App\Models\Boat;

class DetailsRepository implements DetailsRepositoryInterface
{
    /**
     * Get Boat Model
     * @param array basic info
     */
    public function getModel()
    {
        try {
            return Boat::where('user_id', Auth()->user()->id)->where('payment_status', 'unpaid')->where('is_active', 'N')->where('model', '!=', null)->latest()->first();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getOptionId($uuid)
    {
        $optionId = Option::where('uuid', $uuid)->first();
        return $optionId->id;
    }

    public function storeOtherInformation(array $otherInformationData, $boatUuid)
    {
        try {

            $boat = Boat::where('user_id', Auth()->user()->id);
            if(!empty($boatUuid)) {
                $boat = $boat->where('uuid', $boatUuid)
                        // ->where('payment_status', 'paid')
                        ->first();
            }else {
                $boat = $boat->where('payment_status', 'unpaid')
                             ->where('is_active', 'N')
                             ->latest()->first();
            }

            //year-make-model-uuid
            // $slugString = preg_replace('/[^A-Za-z0-9\-]/', ' ', $boat->year.' '.$boat->brand->name.' '.$boat->model.' '.$boat->uuid);
            // $boatSlug =  Str::slug($slugString, '-');

            $boat->hull_material = $otherInformationData['hull_material'];
            $boat->boat_name = $otherInformationData['boat_name'];
           // $boat->slug = $boatSlug;
            $boat->save();

            $otherInformation = OtherInformation::where('boat_id', $boat->id)->first();

            if(empty($otherInformation)) {
                $otherInformation = new OtherInformation;
                $otherInformation->boat_id = $boat->id;
            }
            $otherInformation['12_digit_HIN'] = $otherInformationData['hull_id'];
            if(array_key_exists('anchor_type', $otherInformationData)) {
                $otherInformation->anchor_type = $otherInformationData['anchor_type'];
            }
            $otherInformation->fuel_capacity = $otherInformationData['fuel_capacity'];
            $otherInformation->fresh_water = $otherInformationData['fresh_water'];
            $otherInformation->holding = $otherInformationData['holding'];
            $otherInformation->cruising_speed = $otherInformationData['cruising_speed'];
            $otherInformation->max_speed = $otherInformationData['max_speed'];
            $otherInformation->LOA = $otherInformationData['loa'];
            $otherInformation->tanks = $otherInformationData['tank'] ?? 1;
            $otherInformation->designer = $otherInformationData['designer'];
            $otherInformation->head = $otherInformationData['head'];
            if(array_key_exists('generator_fuel_type', $otherInformationData)) {
                $otherInformation->generator_fuel_type = $otherInformationData['generator_fuel_type'];
                $otherInformation->generator_size = $otherInformationData['generator_size'];
                $otherInformation->generator_hours = $otherInformationData['generator_hours'];
            }
            if(array_key_exists('cabin_berths', $otherInformationData)) {
                $otherInformation->cabin_berths = $otherInformationData['cabin_berths'];
                $otherInformation->cabin_description = $otherInformationData['cabin_description'];
            }
            if(array_key_exists('galley_description', $otherInformationData)) {
                $otherInformation->galley_description = $otherInformationData['galley_description'];
            }
            if(array_key_exists('electrical_system', $otherInformationData)) {

                $implodeElectricalSytem = implode(",",$otherInformationData['electrical_system']);
                $otherInformation->electrical_system = $implodeElectricalSytem;
                // $otherInformation->electrical_system = $otherInformationData['electrical_system'];
            }
            $otherInformation->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }

    }

    /**
     * Create new Engines.
     * @param array basic info
     */
    public function storeEngine(array $engines, $boatUuid)
    {

        $boat = Boat::where('user_id', Auth()->user()->id);
        if(!empty($boatUuid)) {
            $boat = $boat->where('uuid', $boatUuid)
                         ->where('payment_status', 'paid')->first();
        }else {
            $boat = $boat->where('payment_status', 'unpaid')
                         ->where('is_active', 'N')
                         ->latest()->first();
        }

        if(!empty($boat)) {
            $checkEngines = Engine::where('boat_id', $boat->id)->get();
            if(!empty($checkEngines)) {
                foreach($checkEngines as $checked) {
                    $checked->delete();
                }
            }
        }

        try
        {
            foreach($engines as $chunk) {
                $temp = [];
                foreach($chunk as $data) {
                    if(!empty($data)) {
                        array_push($temp, $data);
                    }
                }
                if(!empty($temp)) {
                    $engine = new Engine;
                    $engine->boat_id = $boat->id;
                    $engine->engine_type = $chunk[0];
                    $engine->fuel_type = $chunk[1];
                    $engine->make = $chunk[2];
                    $engine->model = $chunk[3];
                    $engine->horse_power = $chunk[4];
                    $engine->engine_hours = $chunk[5];
                    $engine->save();
                }
            }
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
