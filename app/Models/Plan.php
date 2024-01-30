<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable=[
        'uuid',
      "player_id",
      "matching_id",
      "status"
             
 
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            
            "player_id"=>'integer',
            "matching_id"=>'integer',
            'status'=>'string'
            ];
        
        
        
        
        public function matching(){
        
        return $this->belongsTo(Matching::class);
        
        }
        public function player(){
        
            return $this->belongsTo(Player::class);
            
            }
}
