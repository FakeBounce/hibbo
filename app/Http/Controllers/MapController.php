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


        if(session()->has('item_possessed'))
            $item_possessed = session()->get('item_possessed');
        else
            $item_possessed = [];

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
            "item_possessed"=>$item_possessed,
            "pj_stats"=>$pj_stats
        ]);
    }

    public function turn(Request $request,Map $map)
    {

        $map_tab = session()->get('map_tab');
        $monster_tab = session()->get('monster_tab');
        //$item_tab = session()->get('item_tab');
        $monster_stats = session()->get('monster_stats');
        $pj_stats = session()->get('pj_stats');
        $monster_mv = array();

        foreach($monster_stats as $id=>$m_stats)
        {
            if($m_stats != null)
            {
                $row = $m_stats['row'];
                $col = $m_stats['col'];

                $rg_row = $row - $pj_stats[0]['row'];
                $rg_col = $col - $pj_stats[0]['col'];
                $rg= abs($rg_row)+abs($rg_col);
                if(($rg<=($m_stats->mv + $m_stats->range)) && $map_tab[$m_stats['row']][$m_stats['col']]->type == 'ground')
                {
                    if ($rg <= $m_stats->range)
                    {
                        $monster_mv[$id] = 'hit';
                        $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                    }
                    else
                    {
                        if ($rg_row == 0)
                        {
                            if ($rg_col > 0)
                            {
                                if ($map_tab[$m_stats['row']][$m_stats['col'] - 1]->type == 'ground' && is_null($monster_tab[$m_stats['row']][$m_stats['col'] - 1]))
                                {
                                    $monster_tab[$m_stats['row']][$m_stats['col'] - 1] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['col'] = $m_stats['col'] - 1;
                                    $monster_mv[$id] = "l,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                }
                            }
                            else if ($rg_col < 0)
                            {
                                if ($map_tab[$m_stats['row']][$m_stats['col'] + 1]->type == 'ground' && is_null($monster_tab[$m_stats['row']][$m_stats['col'] + 1]))
                                {
                                    $monster_tab[$m_stats['row']][$m_stats['col'] + 1] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['col'] = $m_stats['col'] + 1;
                                    $monster_mv[$id] = "r,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                }
                            }
                        }
                        else if ($rg_col == 0)
                        {
                            if ($rg_row > 0)
                            {
                                if ($map_tab[$m_stats['row'] - 1][$m_stats['col']]->type == 'ground' && is_null($monster_tab[$m_stats['row'] - 1][$m_stats['col']]))
                                {
                                    $monster_tab[$m_stats['row'] - 1][$m_stats['col']] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['row'] = $m_stats['row'] - 1;
                                    $monster_mv[$id] = "u,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                }
                            }
                            else if ($rg_row < 0)
                            {
                                if ($map_tab[$m_stats['row'] + 1][$m_stats['col']]->type == 'ground' && is_null($monster_tab[$m_stats['row'] + 1][$m_stats['col']]))
                                {
                                    $monster_tab[$m_stats['row'] + 1][$m_stats['col']] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['row'] = $m_stats['row'] + 1;
                                    $monster_mv[$id] = "d,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                }
                            }
                        }
                        else
                        {
                            $done = false;
                            if($rg_row < 0)
                            {
                                if ($map_tab[$m_stats['row'] + 1][$m_stats['col']]->type == 'ground' && is_null($monster_tab[$m_stats['row'] + 1][$m_stats['col']]))
                                {
                                    $monster_tab[$m_stats['row'] + 1][$m_stats['col']] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['row'] = $m_stats['row'] + 1;
                                    $monster_mv[$id] = "d,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                    $done = true;
                                }
                            }
                            if ($rg_row > 0 && $done == false)
                            {
                                if ($map_tab[$m_stats['row'] - 1][$m_stats['col']]->type == 'ground' && is_null($monster_tab[$m_stats['row'] - 1][$m_stats['col']]))
                                {
                                    $monster_tab[$m_stats['row'] - 1][$m_stats['col']] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['row'] = $m_stats['row'] - 1;
                                    $monster_mv[$id] = "u,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                    $done = true;
                                }
                            }
                            if ($rg_col > 0 && $done ==false)
                            {
                                if ($map_tab[$m_stats['row']][$m_stats['col'] - 1]->type == 'ground' && is_null($monster_tab[$m_stats['row']][$m_stats['col'] - 1]))
                                {
                                    $monster_tab[$m_stats['row']][$m_stats['col'] - 1] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['col'] = $m_stats['col'] - 1;
                                    $monster_mv[$id] = "l,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                    $done = true;
                                }
                            }
                            if ($rg_col < 0 && $done == false)
                            {
                                if ($map_tab[$m_stats['row']][$m_stats['col'] + 1]->type == 'ground' && is_null($monster_tab[$m_stats['row']][$m_stats['col'] + 1]))
                                {
                                    $monster_tab[$m_stats['row']][$m_stats['col'] + 1] = $id;
                                    $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                                    $m_stats['col'] = $m_stats['col'] + 1;
                                    $monster_mv[$id] = "r,hit";
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                    $done = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        if($pj_stats[0]->life <=0)
        {
            session()->flush();
            return redirect()->route('map.show', ['map' => $map->id]);
        }
        $pj_actions = $map->getClasse(1);
        $pj_stats[0]->mv = $pj_actions->mv;
        $pj_stats[0]->action = $pj_actions->action;
        session()->put('pj_stats', $pj_stats);
        session()->put('monster_tab', $monster_tab);
        session()->put('monster_stats', $monster_stats);

        return \Response::json(array(
            'success' => true,
            'pj_stats' => $pj_stats,
            'monster_tab' => $monster_tab,
            'monster_stats' => $monster_stats,
            'monster_mv' => $monster_mv,
        ));
    }

    public function action(Request $request, Map $map)
    {
        $data = $request->all();
        $map_tab = session()->get('map_tab');
        $monster_tab = session()->get('monster_tab');
        $item_tab = session()->get('item_tab');
        $monster_stats = session()->get('monster_stats');
        $pj_stats = session()->get('pj_stats');
        $item_possessed = session()->get('item_possessed');
        $item_to_delete = false;
        $update_left_pannel = false;
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
                        $mv_row = $row - $pj_stats[0]['row'];
                        $mv_col = $col - $pj_stats[0]['col'];
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
                                                $movable = 'no';
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
                                                $movable = 'no';
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
                                        $direction = "d";
                                        $ite = $mv_row;
                                        while($ite>0)
                                        {
                                            if($map_tab[$row-$ite][$col]->type== "ground" && $monster_tab[$row-$ite][$col] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                $movable = 'no';
                                                break;
                                            }
                                            $ite--;
                                        }
                                    }
                                    else if($mv_row<0)
                                    {
                                        $direction = "u";
                                        $ite = abs($mv_row);
                                        while($ite>0)
                                        {
                                            if($map_tab[$row+$ite][$col]->type== "ground" && $monster_tab[$row+$ite][$col] == null)
                                            {
                                                $movable = 'ok';
                                            }
                                            else
                                            {
                                                $movable = 'no';
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
                //Add item to inventory if needed
                if($item_tab[$row][$col] != null)
                {
                    if(intval($item_tab[$row][$col]->id) == 1)
                    {
                        if(isset($item_possessed[0]))
                        {
                            $item_possessed[count($item_possessed)] = 1;
                        }
                        else
                        {
                            $item_possessed[0] = 1;
                        }
                    }
                    else
                    {
                        if(isset($item_possessed[0]))
                        {
                            $item_possessed[count($item_possessed)] = 2;
                        }
                        else
                        {
                            $item_possessed[0] = 2;
                        }
                    }
                    $item_to_delete = $row."_".$col;
                    $item_tab[$row][$col] = null;
                }
                $monster_tab[$pj_stats[0]['row']][$pj_stats[0]['col']]=null;
                $pj_stats[0]['row'] = $row;
                $pj_stats[0]['col'] = $col;
                $pj_stats[0]->mv = $pj_stats[0]->mv - $mv;
                session()->put('pj_stats', $pj_stats);
                session()->put('item_possessed', $item_possessed);
                session()->put('item_tab', $item_tab);
            }
        }

        if(isset($data['mid']))
        {
            $id = str_replace("m_", "", $data['mid']);
            $row = intval($monster_stats[$id]['row']);
            $col = intval($monster_stats[$id]['col']);

            $rg_row = $row - $pj_stats[0]['row'];
            $rg_col = $col - $pj_stats[0]['col'];
            $rg= abs($rg_row)+abs($rg_col);
            if($rg<=$pj_stats[0]->range && $map_tab[$monster_stats[$id]['row']][$monster_stats[$id]['col']]->type == 'ground')
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

        if(isset($data["item"]))
        {
            $id = str_replace("item_", "", $data['item']);
            if($item_possessed[$id] == 1)
            {
                $pj_stats[0]->life = 15000;
                $item_possessed[$id] = -1;
                session()->put('item_possessed', $item_possessed);
                $update_left_pannel = true;
            }
            if($item_possessed[$id] == 2)
            {
                $pj_stats[0]->mana = 1000;
                $item_possessed[$id] = -2;
                session()->put('item_possessed', $item_possessed);
                $update_left_pannel = true;
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
            'item_possessed' => $item_possessed,
            'item_to_delete' => $item_to_delete,
            'update_left_pannel' => $update_left_pannel,
        ));
    }
}
