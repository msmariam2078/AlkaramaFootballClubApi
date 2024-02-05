<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'name'=>$this->name,
            'age'=>Carbon::createFromDate($this->born)->age."عام",
            'high'=>$this->high."cm",
            'number'=>$this->number,
            'Play Center'=>$this->play,
        
        ];
    }
}
