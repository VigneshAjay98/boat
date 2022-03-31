<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

         return [
            'id'=> $this->id,
            'title'=> $this->boat_name,
            'uuid'=> $this->uuid,

            // 'author' => $this->author,
            // 'description'=>$this->description,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
            'images' => $this->images,
            'engines' => $this->engine,
            'info' => $this->boatInfo,
            // 'ratings' => $this->ratings,
            // 'average_rating' => $this->ratings->avg('rating')
        ];

        // return parent::toArray($request);
    }
}
