<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{    protected $fillable = [
    'id',
    'name',
    'damage',
    'time_damage',
    'buff_damage',
    'debuff_damage',
    'type_damage',
    'xp',
    'flat_dd',
    'flat_du',
    'flat_dd',
    'percent_dd',
    'percent_du',
    'dr',
    'buff_life',
    'debuff_life',
    'heal',
    'time_heal',
    'forced_mv',
    'buff_mv',
    'debuff_mv',
    'duration',
    'mana',
    'cost_mana',
    'cost_life',
    'minimal_range',
    'linear_range',
    'diagonal_range',
    'linear_aoe',
    'diagonal_aoe',
    'up_aoe',
    'right_aoe',
    'down_aoe',
    'left_aoe',
    'cast',
    'action',
    'down_aoe',
    'reset_cast',
    'break',
    'bonus_description',
    'description',
    'created_at',
    'updated_at'
];
}
