<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SessionResource;
use App\Models\Session;

class PrimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // //return parent::toArray($request);
        // // $session_id=Session::where('uuid',$request->input('session_uuid'))->value('id');
        return[
            'uuid'=>$this->uuid,
            'name' => $this->name,
            'image' => $this->image,
        
            'descreption'=>$this->desc,
            'type'=>$this->type,
            "session"=>$this->session->name." ".$this->session->start_date->format('Y')."-".$this->session->end_date->format('Y'),
            'sport'=>$this->sport->name
            
        ];
     

}
}