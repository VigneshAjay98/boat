<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\BoatLocationRepositoryInterface;

use App\Models\Boat;
use App\Models\BoatImage;
use App\Models\BoatVideo;
use App\Models\Country;
use App\Models\State;
use App\Models\Plan;

class BoatLocationRepository implements BoatLocationRepositoryInterface
{
     /**
     * Get package By User Id.
     * @param array basic info
     */
    public function getPackageByUserId()
    {
        try {
            $boat = Boat::where('user_id', Auth()->user()->id)
                            ->where('payment_status', 'unpaid')
                            ->where('publish_status', 'draft')
                            ->where('is_active', 'N')
                            ->where('country', '!=', null)
                            ->latest()->first();
            if($boat) {
                return Plan::where('id', $boat->plan_id)->first();
            }else {
                return false;
            }

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Get record By Session Id.
     * @param array basic info
     */
    public function getDescription()
    {
        try {
            return Boat::where('user_id', Auth()->user()->id)
                        ->where('payment_status', 'unpaid')
                        ->where('publish_status', 'draft')
                        ->where('is_active', 'N')
                        ->where('general_description', '!=', null)
                        ->where(function($query){
                            $query->where('general_description', '!=', null)
                              ->orWhere('general_description', '!=', '');
                        })
                        ->latest()->first();
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
     * Store images.
     */
    public function storeImages($images, $boatUuid)
    {
        try
        {
            ini_set('memory_limit', '-1');
            $boat = Boat::where('user_id', Auth()->user()->id);
            if(!empty($boatUuid)) {
                $boat = $boat->where('uuid', $boatUuid)
                             ->where('payment_status', 'paid')
                             ->where('publish_status', 'published')
                             ->first();
            }else {
                $boat = $boat->where('payment_status', 'unpaid')
                             ->where('publish_status', 'draft')
                             ->where('is_active', 'N')
                             ->latest()->first();
            }

            $checkImages = BoatImage::where('boat_id', $boat->id)->get();

            if(!empty($checkImages)) {
                foreach($checkImages as $checked) {
                    $checked->delete();
                }
            }

            $folderPath = 'storage/boats/images/'.$boat->uuid.'/';
            if (file_exists($folderPath)) {
                \File::deleteDirectory($folderPath);
            }
            mkdir($folderPath, 0755, true);
            foreach($images as $image) {
                $imageParts = explode(";base64,", $image);
                $imageTypeAux = explode("image/", $imageParts[0]);
                $imageType = $imageTypeAux[1];
                $imageBase64 = base64_decode($imageParts[1]);

                $file = $folderPath . uniqid() . '.'.$imageType;
                file_put_contents($file, $imageBase64);

                $boatImage = new BoatImage;
                $boatImage->boat_id = $boat->id;
                $boatImage->image_name = $file;
                $boatImage->image_type = $imageType;
                $boatImage->save();
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Store Videos.
     */
    public function storeVideos($videos, $boatUuid)
    {
        try
        {
            ini_set('memory_limit', '-1');
            $boat = Boat::where('user_id', Auth()->user()->id);
            if(!empty($boatUuid)) {
                $boat = $boat->where('uuid', $boatUuid)
                             ->where('payment_status', 'paid')
                             ->where('publish_status', 'published')
                             ->first();
            }else {
                $boat = $boat->where('payment_status', 'unpaid')
                             ->where('publish_status', 'draft')
                             ->where('is_active', 'N')
                             ->latest()->first();
            }

            $checkVideos = BoatVideo::where('boat_id', $boat->id)->get();

            if(count($checkVideos) > 0) {
                foreach($checkVideos as $checked) {
                    $checked->delete();
                }
            }

            $folderPath = 'storage/boats/videos/'.$boat->uuid.'/';
            if (file_exists($folderPath)) {
                \File::deleteDirectory($folderPath);
            }
            mkdir($folderPath, 0755, true);
            foreach($videos as $video) {
                $videoParts = explode(";base64,", $video);
                $videoTypeAux = explode("video/", $videoParts[0]);
                $videoType = $videoTypeAux[1];
                $videoBase64 = base64_decode($videoParts[1]);

                $file = $folderPath . uniqid() . '.'.$videoType;
                file_put_contents($file, $videoBase64);

                $boatVideo = new BoatVideo;
                $boatVideo->boat_id = $boat->id;
                $boatVideo->video_name = $file;
                $boatVideo->video_type = $videoType;
                $boatVideo->save();
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Create new Basic Info.
     * @param array basic info
     */
    public function store(array $locationInfoData)
    {

    	try
        {
            $boat = Boat::where('user_id', Auth()->user()->id);
            if(!empty($locationInfoData['boat_uuid'])) {
                $boat = $boat->where('uuid', $locationInfoData['boat_uuid'])
                             ->where('payment_status', 'paid')
                             ->where('publish_status', 'published')
                             ->first();
            }else {
                $boat = $boat->where('payment_status', 'unpaid')
                             ->where('publish_status', 'draft')
                             ->where('is_active', 'N')
                             ->latest()->first();
            }

            if(!empty($boat)) {
                $boat->country = $locationInfoData['country'];
                $boat->state = $locationInfoData['state'];
                $boat->zip_code = $locationInfoData['zip_code'];
                $boat->save();
            }
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
