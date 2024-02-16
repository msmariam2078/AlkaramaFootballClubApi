<?php

namespace App\Http\Resources;
use App\Models\Club;
use Illuminate\Http\Resources\Json\JsonResource;

class StandingResource extends JsonResource
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
            'club name'=>$this->club->name,
            'play'=>$this->play,
            'win'=>$this->win,
            'lose'=>$this->lose,
            'draw'=>$this->draw,
            // '+/-'=>'required|integer',
            'points'=>$this->win,
            'play'=>$this->play,


        ];
    }
}
