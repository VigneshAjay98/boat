<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\OptionRepositoryInterface;

use App\Models\Option;

class OptionRepository implements OptionRepositoryInterface
{
    /**
     * get a Option
     * @param string
     * @return collection
     */
    public function get()
    {
        return Option::all();
    }

    /**
     * get all boat active types
     * @param string
     * @return collection
     */
    public function getActiveBoatTypes() {
        return Option::where('option_type', 'boat_type')->where('is_active', 'Y')->get();
    }

    /**
     * get all hull materials
     * @param string
     * @return collection
     */
    public function getHullMaterials() {
        return Option::where('option_type', 'hull_material')->where('is_active', 'Y')->orderBy('name','asc')->get();
    }

    /**
     * get all boat active activities
     * @param string
     * @return collection
     */
    public function getActiveActivities() {
        return Option::where('option_type', 'boat_activity')->where('is_active', 'Y')->get();
    }

    /**
     * get all boat type related option
     * @param string
     * @return collection
     */
    public function getBoatTypeOption($typeName) {
        return Option::where('option_type', 'boat_type')->where('name', $typeName)->where('is_active', 'Y')->first();
    }

    /**
     * get a Option by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return Option::byUuid($uuid)->first();
    }
    /**
     * Create new User.
     * @param array User data
     */
    public function create(array $optionData)
    {
        $option = new Option();
        try {
            $option->name = $optionData['name'];
            $option->option_type = $optionData['option_type'];
            // $option->slug = $optionData['name'];
            $option->save();
            return $option;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing Option.
     *
     * @param option object
     * @param array option data
     */
    public function update(Option $option, array $optionData)
    {
        try {
            $option->name = $optionData['name'];
            $option->option_type = $optionData['option_type'];
            // $option->slug = $optionData['name'];
            $option->save();
            return $option;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Change status of option.
     * @param Option object
     */
    public function changeStatus(Option $option)
    {
        try {
            $option->is_active = ($option->is_active == 'N') ? 'Y' : 'N';
            $option->save();
            return $option;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    /**
     * Delete a Option.
     * @param Option object
     */
    public function delete(Option $option)
    {
        try {
            return $option->delete() ? true : false;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
