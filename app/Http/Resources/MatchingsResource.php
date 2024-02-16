<?php

namespace App\Http\Resources;

use App\Http\Resources\PlanResource;
use App\Http\Resources\ReplacmentResource;
use App\Http\Resources\StatisticResource;
use App\Http\Resources\InformationResource;
use App\Http\Resources\VideoResource;
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
            'uuid'=>$this->uuid,
         'first_club'=>$this->club1->name,
         'first_club_logo'=>$this->club1->logo,
         'second_club'=>$this->club2->name,
         'second_club_logo'=>$this->club2->logo,
         'play_ground'=>$this->play_ground,
         'when'=>$this->when->format('d M  Y H:i:S'),
         'round'=>$this->round,
         'status'=>$this->status,
         'plan_image'=>$this->plan_image,
         'channel'=>$this->channel,
         'round'=>$this->round,
         'play_ground'=>$this->play_ground,
         "session"=>$this->session->name." ".$this->session->start_date->format('Y')."-".$this->session->end_date->format('Y'),
         'plan'=>PlanResource::collection($this->plans),
         'replacement'=>ReplacmentResource::collection($this->replacments),
         'statistics'=>StatisticResource::make($this->statistic),
         'videos'=>videoResource::collection($this->videos)
      
        ];
    }
}
