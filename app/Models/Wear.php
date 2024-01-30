<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wear extends Model
{
    use HasFactory;
    protected $fillable=[

        'uuid','image','seasone_id','sport_id'
        
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            'image'=>'string',
            'session_id'=>'integer',
            'sport_id'=>'integer',];

            public function session(){

                return $this->belongTo(Session::class);
                
                }
                public function sport(){

                    return $this->belongTo(Sport::class);
                    
                    }



        
        
        
}
