<?php

namespace App\Http\Resources;
use App\Http\Resources\TopfanResource;

use Illuminate\Http\Resources\Json\JsonResource;

class AssociationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'uuid'=>$this->uuid,
            'boss'=>$this->boss,
            'image'=>env('P').$this->image,
            'descreption'=>$this->descreption,
            'country'=>$this->country,
            'memebers'=>TopfanResource::collection($this->topfans)
        ];
    }
}
