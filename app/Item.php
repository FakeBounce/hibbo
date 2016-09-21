<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'id',
        'url',
        'name',
        'type',
        'created_at',
        'updated_at'
    ];
}
