<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map_tile extends Model
{
    protected $fillable = [
        'id',
        'url',
        'type',
        'break',
        'action',
        'created_at',
        'updated_at'
    ];
}
