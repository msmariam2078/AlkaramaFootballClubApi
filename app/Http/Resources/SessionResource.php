<?php

namespace App\Http\Resources;
use App\Http\Resources\MatchingsResource;
use App\Http\Resources\StandingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
        'start_date'=>$this->start_date,
        'end_date'=>$this->end_date,
        'matches'=>MatchingsResource::collection($this->matchings),
        'standings'=>StandingResource::collection($this->standings)


        ];
    }
}
