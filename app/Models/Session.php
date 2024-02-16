<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable=[
        'uuid',
      "name",
      "start_date",
      "end_date"
                    
        ];
        protected $casts=[
        
            'uuid'=>'string',
            'name'=>'string',
            "start_date"=>'date',
            "end_date"=>'date',
           
            ];
        
        
        
        
        public function primes(){
        
        return $this->hasMany(Prime::class);
        
        }
          
        public function matchings(){
        
            return $this->hasMany(Matching::class);
            
            }
            public function standings(){
        
                return $this->hasMany(Standing::class);
                
                }
                public function wears(){
        
                    return $this->hasMany(Wear::class);
                    
                    }
                    public function informations(){
    
                        return $this->morphMany(Information::class,'information_able');
                                
                         }
                         public function information(){
                
                            return $this->morphOne(Information::class,'information_able');
                                    
                             }
}
