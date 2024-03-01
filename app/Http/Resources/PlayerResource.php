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
            'image'=>env('P').$this->image,
            'name'=>$this->name,
            'born'=>$this->born->format('Y-m-d')." ".$this->from,
            'high'=>$this->high."cm",
            'age'=>Carbon::createFromDate($this->born)->age."عام",
            'number'=>$this->number,
            'Play Center'=>$this->play,
            'first_club'=>$this->first_club,
            'career' =>$this->career
        
        ];
    }
}
