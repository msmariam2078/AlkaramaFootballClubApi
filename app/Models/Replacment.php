<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replacment extends Model
{
    use HasFactory;
    protected $fillable=[
        'uuid',
        "outplayer_id",
        "inplayer_id",
      "matching_id",
     
             
 
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
           "outplayer_id"=>'integer',
            "inplayer_id"=>'integer',
          "matching_id"=>'integer',
            ];
            public function outPlayer(){

                return $this->belongsTo(Player::class,"outplayer_id");
                
                }
                public function inPlayer(){

                    return $this->belongsTo(Player::class,"inplayer_id");
                    
                    }
                    public function matching(){

                        return $this->belongsTo(Matching::class);
                        
                        }
        
}
