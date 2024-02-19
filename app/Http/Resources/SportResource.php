<?php

namespace App\Http\Resources;
use App\Http\Resources\ClubResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SportResource extends JsonResource
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
       "name"=>$this->name,
       'image'=>env('P').$this->image,
       'clubs'=>ClubResource::collection($this->clubs)

        ];
    }
}
