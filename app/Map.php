<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Map_tile;
use App\Monster;
use App\Item;

class Map extends Model
{
    protected $fillable = [
        'id',
        'name',
        'tile_set',
        'monster_set',
        'item_set',
        'monster_range',
        'width',
        'height',
        'floor',
        'description',
        'created_at',
        'updated_at'
    ];

    public function getMap_tile($id){
        $map_tile = Map_tile::where('id', $id)->first();

        return $map_tile;
    }
    public function getMonster($id){
        $monster = Monster::where('id', $id)->first();
        return $monster;
    }

    public function getItem($id){
        $item = Item::where('id', $id)->first();
        return $item;
    }
}
