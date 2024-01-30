<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'boss',
        'image',
        'description',
        'country',
        'sport_id'
    ];

    protected $casts = [
        'uuid' => 'string',
        'boss' => 'string',
        'image' => 'string',
        'description' => 'string',
        'country' => 'string',
        'sport_id' => 'integer',
    ];

    public function sport(): object
    {
        return $this->belongsTo(Sport::class);
    }

    public function topfans(): object
    {
        return $this->hasMany(Topfan::class);
    }
    public function videos(){
    
        return $this->morphMany(Video::class);
        
        }
}
