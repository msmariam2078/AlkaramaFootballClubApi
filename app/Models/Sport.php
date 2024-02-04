<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $fillable=[

        'uuid','name','image'
        
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            'name'=>'string',
            'image'=>'string',
            
          ];
          public function clubs(){

            return $this->hasMany(Club::class);
            
            }
            public function employees(){

                return $this->hasMany(Employee::class);
                
                }
                public function primes(){

             return $this->hasMany(Prime::class);
                    
              }
        public function associations(){

        return $this->hasMany(Association::class);
                        
            }
        public function wears(){

            return $this->hasMany(Wear::class);
                            
             }
             public function players(){

            return $this->hasMany(Player::class);
                                
                                }
}
