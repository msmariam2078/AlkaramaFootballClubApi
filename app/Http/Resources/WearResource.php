<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WearResource extends JsonResource
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
     'image'=>$this->image,
     "session"=>$this->session->name." ".$this->session->start_date->format('Y')."-".$this->session->end_date->format('Y'),
     'sport'=>$this->sport->name
        ];
    }
}
