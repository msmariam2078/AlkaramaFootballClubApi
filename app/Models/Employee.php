<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=[

       'uuid',
        'name',
        'job_type',
       'work',
        'image',
        "sport_id"
        
        
        
        ];
        protected $casts=[

            'uuid'=>'string',
            'name'=>'string',
            'job_type'=>'string',
           'work'=>'string',
            'image'=>'string',
            "sport_id"=>'integer',
        
          ];
        
        
        
        
        public function sport(){
        
        return $this->belongsTo(Sport::class);
        
        }
}
