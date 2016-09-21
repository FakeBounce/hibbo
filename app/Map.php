<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Map_tile;
use App\Monster;

class Map extends Model
{
    protected $fillable = [
        'id',
        'name',
        'tile_set',
        'monster_set',
        'item_set',
        'width',
        'height',
        'floor',
        'description',
        'created_at',
        'updated_at'
    ];

    public function getMap_tile($val){

        $map_tile = Map_tile::find($val);

        return $map_tile;
    }
    public function getMonster($id){
        $monster = Monster::find($id);
        return $monster;
    }
}
