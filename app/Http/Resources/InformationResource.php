<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
        'info_about_uuid'=>$this->information_able->uuid,
        'info_about_name'=>$this->information_able->name?$this->information_able->name:'match',
        'title'=>$this->title,
      'content'=>$this->content,
      'image'=>$this->image,
      'reads'=>$this->reads,
      'type'=>$this->type





        ];
    }
}
