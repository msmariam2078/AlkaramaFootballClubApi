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
            'Club'=>$this->club->name,
            'Play'=>$this->play,
            'Lose'=>$this->lose,
            'Win'=>$this->win,
            'Draw'=>$this->draw,
            '+/-'=>$request->balanced,
            'Points'=>$this->win
        ];
    }
}
