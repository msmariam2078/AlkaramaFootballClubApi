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
    
        return $this->hasMany(Matching::class);
        
        }
  
}
