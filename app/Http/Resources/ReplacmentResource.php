<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PlayerResource;
class ReplacmentResource extends JsonResource
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
    'in_player'=>PlayerResource::make($this->inPlayer),
    'out_player'=>PlayerResource::make($this->outPlayer)



        ];
    }
}
