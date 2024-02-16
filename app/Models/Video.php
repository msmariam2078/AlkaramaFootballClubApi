<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable=[

 
        'uuid',"url","desc"


];
protected $casts=[

    'uuid'=>'string',
    'url'=>'string',
    'desc'=>'string',
   
];

public function video_able(){


    $this->morphTo();
 
   }



}
