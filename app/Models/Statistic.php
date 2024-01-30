<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $fillable=[
        'uuid',
      "name",
      "value",
      'matching_id'
      
             
 
        
        
        ];
        protected $casts=[
        
            'uuid'=>'string',
            
            "name"=>'string',
            "value"=>'json',
            "matching_id"=>"integer"
          
            ];
            public function matchings(){
        
                return $this->belongsTo(Matching::class);
                
                }
}
