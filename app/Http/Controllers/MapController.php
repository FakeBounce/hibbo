<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Map;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MapController extends Controller
{

    public function show(Map $map){

        $map_tiles = explode(" ",$map->tile_set);
        $monsters = explode(" ",$map->monster_set);
        $items = explode(" ",$map->item_set);
        $monsters_range = explode(" ",$map->monster_range);

        if(session()->has('map_tab'))
            $map_tab = session()->get('map_tab');
        else
            $map_tab = [];

        if(session()->has('monster_tab'))
            $monster_tab = session()->get('monster_tab');
        else
            $monster_tab = [];

        if(session()->has('item_tab'))
            $item_tab = session()->get('item_tab');
        else
            $item_tab = [];

        if(session()->has('monster_stats'))
            $monster_stats = session()->get('monster_stats');
        else
            $monster_stats = [];

        return view('map/show', [
            "map" => $map,
            "map_tiles"=>$map_tiles,
            "monsters"=>$monsters,
            "items"=>$items,
            "monsters_range"=>$monsters_range,
            "map_tab"=>$map_tab,
            "monster_tab"=>$monster_tab,
            "item_tab"=>$item_tab,
            "monster_stats"=>$monster_stats
        ]);
    }
}
