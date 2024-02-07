<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable=[

 
        'uuid',"title",'content','image','reads','type'


];
protected $casts=[

    'uuid'=>'string',
    "title"=>'string',
    'content'=>'string',
    'image'=>'string',
    'reads'=>'string',
    'type'=>'string',
];

public function information_able(){


   return $this->morphTo();
 
   }

}
