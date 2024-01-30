<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;
    protected $fillable=[

        'uuid','win','lose','draw','+/-','points','play','session_id','club_id'
        
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            'win'=>'integer',
            'lose'=>'integer',
            'draw'=>'integer',
            '+/-'=>'integer',
           'points'=>'integer',
            'play'=>'integer',
            'session_id'=>'integer',
            'club_id'=>'integer'
        ];
        public function session(){

            return $this->belongTo(Session::class);
            
            }
            public function club(){

                return $this->belongTo(Club::class);
                
                }





        
}
