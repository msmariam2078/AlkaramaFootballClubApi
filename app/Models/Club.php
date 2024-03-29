<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    
protected $fillable=[

    'uuid','name','address','logo','sport_id'
    
    
    
    ];
    protected $casts=[
    
        'uuid'=>'string',
        'name'=>'string',
       'address'=>'string',
        'logo'=>'string',
        "sport_id"=>'integer',];
    
    
    
    
    public function sport(){
    
    return $this->belongsTo(Sport::class);
    
    }
    public function matchesAsClub1(){
    
        return $this->hasMany(Matching::class,"club1_id");
        
        }
        public function matchesAsClub2(){
    
        return $this->hasMany(Matching::class,"club2_id");
            
            }
            public function standings(){
    
         return $this->hasMany(Standing::class);
                
                }
        public function informations(){
    
            return $this->morphMany(Information::class,'information_able');
                    
             }
             public function information(){
    
                return $this->morphOne(Information::class,'information_able');
                        
                 }
                 public function video(){
    
                    return $this->morphOne(Video::class,'video_able');
                            
                     }
                     public function videos(){
    
                        return $this->morphMany(Video::class,'video_able');
                                
                         }
      
  
}
