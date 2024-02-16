<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wear extends Model
{
    use HasFactory;
    protected $fillable=[

        'uuid','image','session_id','sport_id'
        
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            'image'=>'string',
            'session_id'=>'integer',
            'sport_id'=>'integer',];

            public function session(){

                return $this->belongsTo(Session::class);
                
                }
                public function sport(){

                    return $this->belongsTo(Sport::class);
                    
                    }



        
        
        
}
