<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

protected $fillable=[

'uuid','name','high','number','play','born','from','first_club','career','image','sport_id'



];
protected $casts=[

    'uuid'=>'string',
    'name'=>'string',
    'high'=>'integer',
    'play'=>'string',
    'number'=>'integer',
    'born'=>'date',
   'from'=>'string',
    'first_club'=>'string',
    'career'=>'json',
    'image'=>'string',
    "sport_id"=>'integer',];




public function plans(){

return $this->hasMany(Plan::class);

}

public function replacments(){

    return $this->hasMany(Replacment::class);
    
    }



}
