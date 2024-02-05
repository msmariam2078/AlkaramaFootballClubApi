<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerDetailsResource extends JsonResource
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
            'born'=>$this->from."  ".$this->born->format('d M  Y'),
            'high'=>$this->high."cm",
            'Play Center'=>$this->play,
            'first_club'=>$this->first_club,
            'career' =>$this->career
        
        ];
      
    }
   
}
