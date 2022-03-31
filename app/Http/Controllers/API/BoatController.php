<?php


namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

use App\Http\Resources\BoatResource;
use App\Models\Boat;

class BoatController 
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return BoatResource::collection(Boat::simplePaginate(1));
    }

    public function show(Boat $boat){
        return new BoatResource($boat);
    }
    
}