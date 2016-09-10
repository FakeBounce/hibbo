<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [
        'id',
        'name',
        'life',
        'armor',
        'damage',
        'range',
        'mv',
        'xp',
        'gold',
        'flat_dd',
        'percent_dd',
        'dr',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}
