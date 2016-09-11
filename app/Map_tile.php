<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map_tile extends Model
{
    protected $fillable = [
        'id',
        'name',
        'tile_set',
        'description',
        'created_at',
        'updated_at'
    ];
}
