<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'image',
        'type',
        'session_id',
        'sport_id'
    ];

    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'description' => 'string',
        'image' => 'string',
        'type' => 'string',
        'session_id' => 'integer',
        'sport_id' => 'integer',
    ];

    public function sport(): object
    {
        return $this->belongsTo(Sport::class);
    }

    public function session(): object
    {
        return $this->belongsTo(Session::class);
    }
}
