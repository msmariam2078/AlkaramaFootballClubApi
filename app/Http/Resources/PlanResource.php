<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PlayerResource;
use App\Models\Plan;
use App\Models\Matching;
use App\Models\Player;


class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        
       
        return[
            'uuid'=>$this->uuid,
            
            'player' => PlayerResource::make($this->player),

            'status' => $this->status,
            
        ];
    }
}
