<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchingsResource extends JsonResource
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
         'first_club'=>$this->club1->name,
         'first_club_logo'=>$this->club1->logo,
         'second_club'=>$this->club2->name,
         'second_club_logo'=>$this->club2->logo,
         'play_ground'=>$this->play_ground,
         'when'=>$this->when,
         'round'=>$this->round
        ];
    }
}
