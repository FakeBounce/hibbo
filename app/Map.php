<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'id',
        'name',
        'tile_set',
        'width',
        'height',
        'floor',
        'description',
        'created_at',
        'updated_at'
    ];
}
