<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\BoatRepositoryInterface;

use App\Models\Boat;
use App\Models\BoatImage;
use App\Models\UserPlanAddon;

class BoatRepository implements BoatRepositoryInterface
{
    /**
     * get a Boat
     * @param string
     * @return collection
     */
    public function get()
    {
        return Boat::all();
    }
/**
     * get a Boat by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return Boat::where('uuid',$uuid)->first();
    }

    /**
     * get all boat cities
     * @param string
     * @return collection
     */
    public function getAllCities()
    {
        return DB::select("SELECT DISTINCT `city` FROM `boats`");
    }

    /**
	 * Get a boat by brand id and model name
	 *
	 * @param int
	 */
	public function getByModelAndBrandId($modelName, $brandId)
    {
        return Boat::where('model',$modelName)->where('brand_id',$brandId)->get();
    }

    public function saveUserBoat($subscriptionId) 
    {
        $boat = Boat::where('user_id', Auth()->user()->id)->where('payment_status', 'unpaid')->where('publish_status', 'draft')->where('is_active', 'N')->latest()->first();

        if($boat) {
            try {
                $boat->subscription_id = $subscriptionId;
                $boat->payment_status = 'paid';
                $boat->is_active = 'Y';
                $boat->publish_status = 'published';
                $boat->save();

                return true;
            } catch (\Exception $exception) {
                throw $exception;
            }
        }
    }

/**
	 * Get boats information by slug
	 *
	 * @param int
	 */
	public function getBySlug($slug){
        return Boat::whereSlug($slug)->first();
    }
    /**
     * Create new boat.
     * @param array Boat data
     */
    public function create(array $boatData)
    {
        $boat = new Boat();
        try {
            // $boat->name = $boatData['name'];
            // $boat->description = $boatData['description'];
            $boat->save();
            return $boat;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing boat.
     *
     * @param Boat object
     * @param array Boat data
     */
    public function update(Boat $boat, array $boatData)
    {
        try {
            // $boat->name = $boatData['name'];
            // $boat->slug = $boatData['slug'] ?? $boat->slug;
            // $boat->description = $boatData['description'];
            $boat->save();
            return $boat;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

 /**
	 * Updates boat status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(Boat $boat, $status){
        try {
            $boat->status =  ($status == 0) ? '1' : '0';
            $boat->save();
            return $boat;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
	 * Delete a boat.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Boat $boat){
        DB::beginTransaction();
		try {
			$boat->delete();
		} catch (\Exception $exception) {
			DB::rollBack();
			throw $exception;
		}
		DB::commit();
		return $boat;
    }

}
