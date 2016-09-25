<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Map;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MapController extends Controller
{

    public function reset(Map $map)
    {
        session()->flush();
        return redirect()->route('map.show', ['map' => $map->id]);
    }

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

        if(session()->has('pj_stats'))
            $pj_stats = session()->get('pj_stats');
        else
            $pj_stats = [];

        return view('map/show', [
            "map" => $map,
            "map_tiles"=>$map_tiles,
            "monsters"=>$monsters,
            "items"=>$items,
            "monsters_range"=>$monsters_range,
            "map_tab"=>$map_tab,
            "monster_tab"=>$monster_tab,
            "item_tab"=>$item_tab,
            "monster_stats"=>$monster_stats,
            "pj_stats"=>$pj_stats
        ]);
    }

    public function action(Request $request, Map $map)
    {
        $data = $request->all();
        $map_tab = session()->get('map_tab');
        $monster_tab = session()->get('monster_tab');
        //$item_tab = session()->get('item_tab');
        $monster_stats = session()->get('monster_stats');
        $pj_stats = session()->get('pj_stats');
        $movable = 0;
        $mv = 0;
        $row = 0;
        $col = 0;
        $direction = "";
        $monster_hit = array();

        if(isset($data["id"]))
        {
            if($data["id"]>0)
            {
                $row = floor($data["id"]/$map->width);
                $col = $data["id"]%$map->width;

                if($map_tab[$row][$col]->type == "ground")
                {
                    if($monster_tab[$row][$col] == null)
                    {
                        $mv_row = $row - $pj_stats['row'];
                        $mv_col = $col - $pj_stats['col'];
                        $mv = abs($mv_row)+abs($mv_col);
                        if($mv>=0 && ($mv<=(($pj_stats[0]->mv))))
                        {
                            if($mv>1)
                            {
                                if($mv_row == 0)
                                {
                                    if($mv_col>0)
                                    {
                                        $direction = "r";
                                        $ite = $mv_col;
                                        while($ite>0)
                                        {
                                            if($map_tab[$row][$col-$ite]->type== "ground" && $monster_tab[$row][$col-$ite] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                break;
                                            }
                                            $ite--;
                                        }
                                    }
                                    else if($mv_col<0)
                                    {
                                        $direction = "l";
                                        $ite = abs($mv_col);
                                        while($ite>0)
                                        {
                                            if($map_tab[$row][$col+$ite]->type== "ground" && $monster_tab[$row][$col+$ite] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                break;
                                            }
                                            $ite--;
                                        }
                                    }
                                }
                                else if($mv_col == 0)
                                {
                                    if($mv_row>0)
                                    {
                                        $direction = "u";
                                        $ite = $mv_row;
                                        while($ite>0)
                                        {
                                            if($map_tab[$row-$ite][$col]->type== "ground" && $monster_tab[$row-$ite][$col] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                break;
                                            }
                                            $ite--;
                                        }
                                    }
                                    else if($mv_row<0)
                                    {
                                        $direction = "d";
                                        $ite = abs($mv_row);
                                        while($ite>0)
                                        {
                                            if($map_tab[$row+$ite][$col]->type== "ground" && $monster_tab[$row+$ite][$col] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                break;
                                            }
                                            $ite--;
                                        }
                                    }
                                }
                                else
                                {
                                    $movable = 'no';
                                }
                            }
                            else
                            {
                                if($mv_col>0)
                                    $direction = "r";
                                if($mv_col<0)
                                    $direction = "l";
                                if($mv_row>0)
                                    $direction = "d";
                                if($mv_row<0)
                                    $direction = "u";
                                $movable = 'ok';
                            }
                        }
                        else
                        {
                            $movable = 'no';
                        }
                    }
                    else
                    {
                        $movable = 'monster';
                    }
                }
                else
                {
                    $movable = 'wall';
                }
            }
            if($movable == "ok")
            {
                $monster_tab[$pj_stats['row']][$pj_stats['col']]=null;
                $pj_stats['row'] = $row;
                $pj_stats['col'] = $col;
                $pj_stats[0]->mv = $pj_stats[0]->mv - $mv;
                session()->put('pj_stats', $pj_stats);
            }
        }

        if(isset($data['mid']))
        {
            $id = str_replace("m_", "", $data['mid']);
            $row = intval($monster_stats[$id]['row']);
            $col = intval($monster_stats[$id]['col']);

            $rg_row = $row - $pj_stats['row'];
            $rg_col = $col - $pj_stats['col'];
            $rg= abs($rg_row)+abs($rg_col);
            if($rg<=$pj_stats[0]->range)
            {
                if($pj_stats[0]->action>=10)
                {

                    if($rg_col>0)
                        $direction = "r";
                    if($rg_col<0)
                        $direction = "l";
                    if($rg_row>0)
                        $direction = "d";
                    if($rg_row<0)
                        $direction = "u";
                    $movable="attack";
                    $pj_stats[0]->action = $pj_stats[0]->action - 10;
                    $monster_stats[$monster_tab[$row][$col]]->life = $monster_stats[$monster_tab[$row][$col]]->life - $pj_stats[0]->damage;

                    if($monster_stats[$monster_tab[$row][$col]]->life <=0)
                    {
                        $monster_hit[$monster_tab[$row][$col]] ="dead";
                        $monster_stats[$monster_tab[$row][$col]] = null;
                        $monster_tab[$row][$col] = null;
                    }
                    else
                    {
                        $monster_hit[$monster_tab[$row][$col]] ="hit";
                    }
                    session()->put('pj_stats', $pj_stats);
                    session()->put('monster_tab', $monster_tab);
                    session()->put('monster_stats', $monster_stats);
                }
            }
        }
        return \Response::json(array(
            'success' => true,
            'movable' => $movable,
            'direction' => $direction,
            'mv' => $mv,
            'pj_stats' => $pj_stats,
            'monster_hit' => $monster_hit,
            'monster_stats' => $monster_stats,
        ));
    }
}
