<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;
    
protected $fillable=[

 
            'uuid',"when",'status','plan','channel','round','play_ground',"session_id","club1_id","club2_id"
    
    
    ];
    protected $casts=[
    
        'uuid'=>'string',
        "when"=>'string',
        'status'=>'string',
        'plan_image'=>'string',
        'channel'=>'string',
        'round'=>'string',
        'play_ground'=>'string',
        "session_id"=>'integer',
        "club1_id"=>'integer',
        "club2_id"=>'integer'
    ];

    public function club1(){

    return $this->belongTo(Club::class,'club1_id');
    
    }
    public function club2(){

        return $this->belongTo(Club::class,'club2_id');
        
        }
        public function session(){

            return $this->belongTo(session::class);
            
            }
            public function statistic(){

                return $this->hasOne(Statistic::class);
                
                }
                public function plans(){

                    return $this->hasMany(Plan::class);
                    
                    }
                    public function replacments(){

                        return $this->hasMany(Replacment::class);
                        
                        }



}
