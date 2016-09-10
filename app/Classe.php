<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'id',
        'name',
        'life',
        'mana',
        'armor',
        'damage',
        'range',
        'mv',
        'flat_dd',
        'percent_dd',
        'dr',
        'action',
        'created_at',
        'updated_at'
    ];
}
