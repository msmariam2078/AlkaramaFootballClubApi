<?php

namespace App\Http\Resources;
use App\Http\Resources\VideoResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
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
           'uuid'=>$this->uuid, 
          'name'=>$this->name,
          'address'=>$this->address,
          'logo'=>$this->logo,
          'videos'=>VideoResource::collection($this->videos)
          




        ];
    }
}
