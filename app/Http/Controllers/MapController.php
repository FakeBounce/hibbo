<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Map;
use App\Skill;
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

        if(session()->has('pj_skills'))
            $skills = session()->get('pj_skills');
        else
        {
        $skills = Skill::all();
        session()->put('skills', $skills);
        }

        if(session()->has('pj_kills'))
            $pj_kills = session()->get('pj_kills');
        else
        {
            $pj_kills = 0;
            session()->put('pj_kills', $pj_kills);
        }

        if(session()->has('buffs'))
            $buffs = session()->get('buffs');
        else
        {
            $buffs = array();
            $buffs['pj'] = array();
            session()->put('buffs', $buffs);
        }


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
            "pj_stats"=>$pj_stats,
            "pj_kills"=>$pj_kills,
            "skills"=>$skills,
            "buffs"=>$buffs
        ]);
    }

    public function turn(Request $request,Map $map)
    {

        $map_tab = session()->get('map_tab');
        $monster_tab = session()->get('monster_tab');
        //$item_tab = session()->get('item_tab');
        $monster_hit = array();
        $monster_stats = session()->get('monster_stats');
        $pj_stats = session()->get('pj_stats');
        $buffs = session()->get('buffs');
        $pj_kills = session()->get('pj_kills');
        $monster_mv = array();
        $boss_heal = false;

        foreach($monster_stats as $id=>$m_stats)
        {
            if($m_stats != null)
            {
                if(!empty($buffs[$id]))
                {
                    if($buffs[$id]>0)
                    {
                        $buffs[$id] = $buffs[$id]-1;
                        $m_stats->life = $m_stats->life - 150;
                        if($m_stats->life<=0)
                        {
                            $m_stats->armor = 0;
                            $monster_hit[$id] = "dead";
                            $monster_tab[$m_stats['row']][$m_stats['col']] = null;
                            $monster_stats[$id] = null;
                            $buffs[$id] = 0;
                            $pj_kills++;
                            if($pj_kills >= 25)
                            {
                                $map_tab[5][11] = $map->getMap_tile(2);
                                $map_tab[6][11] = $map->getMap_tile(2);
                                $map_tab[7][11] = $map->getMap_tile(2);
                                session()->put('map_tab', $map_tab);
                            }
                            continue;
                        }
                        else
                        {
                            $monster_hit[$id] = "hit";
                        }
                    }
                }
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
                        if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
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
                                    if(($m_stats->damage - $pj_stats[0]->flat_dd)>0)
                                    $pj_stats[0]->life = $pj_stats[0]->life - ($m_stats->damage - $pj_stats[0]->flat_dd);
                                    $done = true;
                                }
                            }
                        }
                    }
                }
            }
        }
        if(isset($monster_stats[17]) && $monster_stats[17] != null)
        {
            if(isset($monster_stats[23]) && $monster_stats[23] != null)
            {
                if($monster_stats[23]->life <= 9900)
                {
                    $monster_stats[23]->life = $monster_stats[23]->life +100;
                    $boss_heal = true;
                }
            }
        }
        if(isset($monster_stats[27]) && $monster_stats[27] != null)
        {
            if(isset($monster_stats[23]) && $monster_stats[23] != null)
            {
                if($monster_stats[23]->life <= 9900)
                {
                    $monster_stats[23]->life = $monster_stats[23]->life +100;
                    $boss_heal = true;
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

        if(!empty($buffs))
        {
            if(isset($buffs['pj']['sprint']))
            {
                if($buffs['pj']['sprint']>0)
                {
                    $buffs['pj']['sprint'] = $buffs['pj']['sprint'] -1;
                    $pj_stats[0]->mv = 4;
                }
                else
                {
                    $pj_stats[0]->mv = 2;
                    $buffs['pj']['sprint'] = null;
                }

            }
            if(isset($buffs['pj']['defy_pain']))
            {
                if($buffs['pj']['defy_pain']>0)
                {
                    $buffs['pj']['defy_pain'] = $buffs['pj']['defy_pain'] -1;
                    $pj_stats[0]->flat_dd = 350;
                }
                else
                {
                    $pj_stats[0]->flat_dd = 50;
                    $buffs['pj']['defy_pain'] = null;
                }

            }
            if(isset($buffs['pj']['guillotine']))
            {
                if($buffs['pj']['guillotine']>0)
                {
                    $buffs['pj']['guillotine'] = $buffs['pj']['guillotine'] - 1;
                    $pj_stats[0]->damage = 1500;
                }
                else
                {
                    $pj_stats[0]->damage = 100;
                    $buffs['pj']['guillotine'] = null;
                }

            }
        }
        
        session()->put('pj_stats', $pj_stats);
        session()->put('monster_tab', $monster_tab);
        session()->put('monster_stats', $monster_stats);
        session()->put('buffs', $buffs);
        session()->put('pj_kills', $pj_kills);

        return \Response::json(array(
            'success' => true,
            'pj_stats' => $pj_stats,
            'monster_tab' => $monster_tab,
            'monster_stats' => $monster_stats,
            'monster_mv' => $monster_mv,
            'monster_hit' => $monster_hit,
            'pj_kills' => $pj_kills,
            'buffs' => $buffs,
            'boss_heal' => $boss_heal,
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
        $pj_kills = session()->get('pj_kills');
        $skills = session()->get('skills');
        $buffs = session()->get('buffs');
        $item_to_delete = false;
        $update_left_pannel = false;
        $movable = 0;
        $mv = 0;
        $row = 0;
        $col = 0;
        $direction = "";
        $monster_hit = array();
        $use_skill = false;
        $used_skill = false;
        $skill_used = false;
        $wall_destroyed = false;
        $skill_id = -1;

        if(session()->has('skill_tiles'))
            $skill_tiles = session()->get('skill_tiles');
        else
        {
            $skill_tiles = array();
            session()->put('skill_tiles', $skill_tiles);
        }

        if(session()->has('skill_tiles_aoe'))
            $skill_tiles_aoe = session()->get('skill_tiles_aoe');
        else
        {
            $skill_tiles_aoe = array();
            session()->put('skill_tiles_aoe', $skill_tiles_aoe);
        }

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
                    if($monster_stats[$monster_tab[$row][$col]]->armor > 0)
                    {
                        $monster_stats[$monster_tab[$row][$col]]->armor = $monster_stats[$monster_tab[$row][$col]]->armor - $pj_stats[0]->damage;
                        if($monster_stats[$monster_tab[$row][$col]]->armor <= 0)
                        {
                            $monster_stats[$monster_tab[$row][$col]]->life = $monster_stats[$monster_tab[$row][$col]]->life + $monster_stats[$monster_tab[$row][$col]]->armor;
                            $monster_stats[$monster_tab[$row][$col]]->armor = 0;
                        }
                    }
                    else
                    {
                        $monster_stats[$monster_tab[$row][$col]]->life = $monster_stats[$monster_tab[$row][$col]]->life - $pj_stats[0]->damage;
                    }

                    if($monster_stats[$monster_tab[$row][$col]]->life <=0)
                    {
                        $monster_hit[$monster_tab[$row][$col]] ="dead";
                        $monster_stats[$monster_tab[$row][$col]] = null;
                        $monster_tab[$row][$col] = null;
                        $pj_kills++;
                        if($pj_kills >= 25)
                        {
                            $map_tab[5][11] = $map->getMap_tile(2);
                            $map_tab[6][11] = $map->getMap_tile(2);
                            $map_tab[7][11] = $map->getMap_tile(2);
                            session()->put('map_tab', $map_tab);
                        }
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

        if(isset($data['skill']))
        {

            $skill_tiles_aoe = array();
            $skill_tiles = array();
            session()->put('skill_tiles_aoe', $skill_tiles_aoe);
            session()->put('skill_tiles', $skill_tiles);

            $id = str_replace("sk_", "", $data['skill']);
            $k = 0;
            if($pj_stats[0]->mana >= $skills[$id]->cost_mana && $pj_stats[0]->action >= $skills[$id]->action)
            {
                $use_skill = true;
                $skill_used = $id;
                switch($id)
                {
                    case 0:
                        if($map_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']]->type == 'ground')
                        {
                            $skill_tiles[$k] = ($pj_stats[0]['row']+1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']]->type == 'ground')
                        {
                            $skill_tiles[$k] = ($pj_stats[0]['row']-1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+1]->type == 'ground')
                        {
                            $skill_tiles[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']+1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-1]->type == 'ground')
                        {
                            $skill_tiles[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']-1);
                            $k++;
                        }
                        $k = 0;

                        //rows down
                        if(isset($map_tab[$pj_stats[0]['row'] + 2][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] + 2][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] + 2][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+2).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row'] + 3][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] + 3][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] + 3][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+3).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row'] + 4][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] + 4][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] + 4][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+4).'_'.$pj_stats[0]['col'];
                            $k++;
                        }

                        //rows up
                        if(isset($map_tab[$pj_stats[0]['row'] - 2][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] - 2][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] - 2][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-2).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row'] - 3][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] - 3][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] - 3][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-3).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row'] - 4][$pj_stats[0]['col']]) && ($map_tab[$pj_stats[0]['row'] - 4][$pj_stats[0]['col']]->type == 'ground' || $map_tab[$pj_stats[0]['row'] - 4][$pj_stats[0]['col']]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-4).'_'.$pj_stats[0]['col'];
                            $k++;
                        }

                        //cols right
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+2]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+2]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+2]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']+2);
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+3]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+3]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+3]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']+3);
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+4]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+4]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+4]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']+4);
                            $k++;
                        }

                        //cols right
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-2]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-2]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-2]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']-2);
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-3]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-3]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-3]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']-3);
                            $k++;
                        }
                        if(isset($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-4]) && ($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-4]->type == 'ground' || $map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-4]->break == 1))
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']).'_'.($pj_stats[0]['col']-4);
                            $k++;
                        }
                        break;
                    case 1:
                        $skill_tiles[0] = $pj_stats[0]['row'].'_'.$pj_stats[0]['col'];

                        if($map_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']+1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+1).'_'.($pj_stats[0]['col']+1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']-1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']+1).'_'.($pj_stats[0]['col']-1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']+1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-1).'_'.($pj_stats[0]['col']+1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']-1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = ($pj_stats[0]['row']-1).'_'.($pj_stats[0]['col']-1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']+1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-1]->type == 'ground')
                        {
                            $skill_tiles_aoe[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']-1);
                            $k++;
                        }
                        $k = 0;
                        break;
                    case 2:
                        if($map_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']]->type == 'ground' && $monster_tab[$pj_stats[0]['row'] + 1][$pj_stats[0]['col']] != null)
                        {
                            $skill_tiles[$k] = ($pj_stats[0]['row']+1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']]->type == 'ground' && $monster_tab[$pj_stats[0]['row'] - 1][$pj_stats[0]['col']] != null)
                        {
                            $skill_tiles[$k] = ($pj_stats[0]['row']-1).'_'.$pj_stats[0]['col'];
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+1]->type == 'ground' && $monster_tab[$pj_stats[0]['row']][$pj_stats[0]['col']+1] != null)
                        {
                            $skill_tiles[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']+1);
                            $k++;
                        }
                        if($map_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-1]->type == 'ground' && $monster_tab[$pj_stats[0]['row']][$pj_stats[0]['col']-1] != null)
                        {
                            $skill_tiles[$k] = $pj_stats[0]['row'].'_'.($pj_stats[0]['col']-1);
                            $k++;
                        }
                        $k = 0;
                        break;
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    $skill_tiles[0] = $pj_stats[0]['row'].'_'.$pj_stats[0]['col'];
                        break;
                    default :
                        $use_skill = false;
                        break;
                }
            }
            else
            {
                $skill_tiles_aoe = array();
                $skill_tiles = array();
            }
            session()->put('skill_tiles_aoe', $skill_tiles_aoe);
            session()->put('skill_tiles', $skill_tiles);
        }

        if(isset($data['skill_use']))
        {
            $values = explode('_',$data['skill_use'][1]);
            $skill_id = $values[0];
            $row = $values[1];
            $col = $values[2];
            
            switch($skill_id)
            {
                case 0:
                    if($row> $pj_stats[0]['row'])
                    {
                        $direction = "d";
                        for($k = 0;$k<4;$k++)
                        {
                            if($k == 0)
                            {
                                if($monster_tab[$row+$k][$col] != null && $map_tab[$row+$k][$col]->type == 'ground')
                                {
                                    if ($monster_stats[$monster_tab[$row + $k][$col]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row + $k][$col]]->armor = $monster_stats[$monster_tab[$row + $k][$col]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row + $k][$col]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row + $k][$col]]->life = $monster_stats[$monster_tab[$row + $k][$col]]->life + $monster_stats[$monster_tab[$row + $k][$col]]->armor;
                                            $monster_stats[$monster_tab[$row + $k][$col]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row + $k][$col]]->life = $monster_stats[$monster_tab[$row + $k][$col]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row + $k][$col]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row + $k][$col]] = "dead";
                                        $monster_stats[$monster_tab[$row + $k][$col]] = null;
                                        $monster_tab[$row + $k][$col] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row+$k;
                                        $pj_stats[0]['col'] = $col;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row + $k][$col]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row+$k][$col]->type == 'ground')
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row+$k;
                                    $pj_stats[0]['col'] = $col;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            else
                            {
                                if($monster_tab[$row+$k][$col] != null && ($map_tab[$row+$k][$col]->type == 'ground' || $map_tab[$row+$k][$col]->break == 1))
                                {
                                    if ($monster_stats[$monster_tab[$row + $k][$col]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row + $k][$col]]->armor = $monster_stats[$monster_tab[$row + $k][$col]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row + $k][$col]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row + $k][$col]]->life = $monster_stats[$monster_tab[$row + $k][$col]]->life + $monster_stats[$monster_tab[$row + $k][$col]]->armor;
                                            $monster_stats[$monster_tab[$row + $k][$col]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row + $k][$col]]->life = $monster_stats[$monster_tab[$row + $k][$col]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row + $k][$col]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row + $k][$col]] = "dead";
                                        $monster_stats[$monster_tab[$row + $k][$col]] = null;
                                        $monster_tab[$row + $k][$col] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row+$k;
                                        $pj_stats[0]['col'] = $col;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row + $k][$col]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row+$k][$col]->type == 'ground' || $map_tab[$row+$k][$col]->break == 1)
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row+$k;
                                    $pj_stats[0]['col'] = $col;
                                }
                                if($map_tab[$row+$k][$col]->break == 1)
                                {
                                    $map_tab[5][11] = $map->getMap_tile(2);
                                    $map_tab[6][11] = $map->getMap_tile(2);
                                    $map_tab[7][11] = $map->getMap_tile(2);
                                    $wall_destroyed = true;
                                    session()->put('map_tab', $map_tab);
                                }
                            }
                        }
                    }
                    else if($row < $pj_stats[0]['row'])
                    {
                        $direction = "u";
                        for($k = 0;$k<4;$k++)
                        {
                            if($k == 0)
                            {
                                if($monster_tab[$row-$k][$col] != null && $map_tab[$row-$k][$col]->type == 'ground')
                                {
                                    if ($monster_stats[$monster_tab[$row-$k][$col]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row-$k][$col]]->armor = $monster_stats[$monster_tab[$row-$k][$col]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row-$k][$col]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row-$k][$col]]->life = $monster_stats[$monster_tab[$row-$k][$col]]->life + $monster_stats[$monster_tab[$row-$k][$col]]->armor;
                                            $monster_stats[$monster_tab[$row-$k][$col]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row-$k][$col]]->life = $monster_stats[$monster_tab[$row-$k][$col]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row-$k][$col]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row-$k][$col]] = "dead";
                                        $monster_stats[$monster_tab[$row-$k][$col]] = null;
                                        $monster_tab[$row-$k][$col] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row-$k;
                                        $pj_stats[0]['col'] = $col;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row - $k][$col]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row-$k][$col]->type == 'ground')
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row-$k;
                                    $pj_stats[0]['col'] = $col;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            else
                            {
                                if($monster_tab[$row-$k][$col] != null && ($map_tab[$row-$k][$col]->type == 'ground' || $map_tab[$row-$k][$col]->break == 1))
                                {
                                    if ($monster_stats[$monster_tab[$row-$k][$col]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row-$k][$col]]->armor = $monster_stats[$monster_tab[$row-$k][$col]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row-$k][$col]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row-$k][$col]]->life = $monster_stats[$monster_tab[$row-$k][$col]]->life + $monster_stats[$monster_tab[$row-$k][$col]]->armor;
                                            $monster_stats[$monster_tab[$row-$k][$col]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row-$k][$col]]->life = $monster_stats[$monster_tab[$row-$k][$col]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row-$k][$col]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row-$k][$col]] = "dead";
                                        $monster_stats[$monster_tab[$row-$k][$col]] = null;
                                        $monster_tab[$row-$k][$col] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row-$k;
                                        $pj_stats[0]['col'] = $col;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row-$k][$col]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row-$k][$col]->type == 'ground' || $map_tab[$row-$k][$col]->break == 1)
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row-$k;
                                    $pj_stats[0]['col'] = $col;
                                }
                                else
                                {
                                    break;
                                }
                                if($map_tab[$row-$k][$col]->break == 1)
                                {
                                    $map_tab[5][11] = $map->getMap_tile(2);
                                    $map_tab[6][11] = $map->getMap_tile(2);
                                    $map_tab[7][11] = $map->getMap_tile(2);
                                    $wall_destroyed = true;
                                    session()->put('map_tab', $map_tab);
                                }
                            }
                        }
                    }
                    else if($col > $pj_stats[0]['col'])
                    {
                        $direction = "r";
                        for($k = 0;$k<4;$k++)
                        {
                            if($k == 0)
                            {
                                if($monster_tab[$row][$col+$k] != null && $map_tab[$row][$col+$k]->type == 'ground')
                                {
                                    if ($monster_stats[$monster_tab[$row][$col+$k]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row][$col+$k]]->armor = $monster_stats[$monster_tab[$row][$col+$k]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row][$col+$k]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row][$col+$k]]->life = $monster_stats[$monster_tab[$row][$col+$k]]->life + $monster_stats[$monster_tab[$row][$col+$k]]->armor;
                                            $monster_stats[$monster_tab[$row][$col+$k]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row][$col+$k]]->life = $monster_stats[$monster_tab[$row][$col+$k]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row][$col+$k]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row][$col+$k]] = "dead";
                                        $monster_stats[$monster_tab[$row][$col+$k]] = null;
                                        $monster_tab[$row][$col+$k] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row;
                                        $pj_stats[0]['col'] = $col+$k;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row][$col+$k]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row][$col+$k]->type == 'ground')
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row;
                                    $pj_stats[0]['col'] = $col+$k;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            else
                            {
                                if($monster_tab[$row][$col+$k] != null && ($map_tab[$row][$col+$k]->type == 'ground' || $map_tab[$row][$col+$k]->break == 1))
                                {
                                    if ($monster_stats[$monster_tab[$row][$col+$k]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row][$col+$k]]->armor = $monster_stats[$monster_tab[$row][$col+$k]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row][$col+$k]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row][$col+$k]]->life = $monster_stats[$monster_tab[$row][$col+$k]]->life + $monster_stats[$monster_tab[$row][$col+$k]]->armor;
                                            $monster_stats[$monster_tab[$row][$col+$k]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row][$col+$k]]->life = $monster_stats[$monster_tab[$row][$col+$k]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row][$col+$k]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row][$col+$k]] = "dead";
                                        $monster_stats[$monster_tab[$row][$col+$k]] = null;
                                        $monster_tab[$row][$col+$k] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row;
                                        $pj_stats[0]['col'] = $col+$k;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row][$col+$k]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row][$col+$k]->type == 'ground' || $map_tab[$row][$col+$k]->break == 1)
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row;
                                    $pj_stats[0]['col'] = $col+$k;
                                }
                                else
                                {
                                    break;
                                }
                                if($map_tab[$row][$col+$k]->break == 1)
                                {
                                    $map_tab[5][11] = $map->getMap_tile(2);
                                    $map_tab[6][11] = $map->getMap_tile(2);
                                    $map_tab[7][11] = $map->getMap_tile(2);
                                    $wall_destroyed = true;
                                    session()->put('map_tab', $map_tab);
                                }
                            }
                        }
                    }
                    else if($col < $pj_stats[0]['col'])
                    {
                        $direction = "l";
                        for($k = 0;$k<4;$k++)
                        {
                            if($k == 0)
                            {
                                if($monster_tab[$row][$col-$k] != null && $map_tab[$row][$col-$k]->type == 'ground')
                                {
                                    if ($monster_stats[$monster_tab[$row][$col-$k]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row][$col-$k]]->armor = $monster_stats[$monster_tab[$row][$col-$k]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row][$col-$k]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row][$col-$k]]->life = $monster_stats[$monster_tab[$row][$col-$k]]->life + $monster_stats[$monster_tab[$row][$col-$k]]->armor;
                                            $monster_stats[$monster_tab[$row][$col-$k]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row][$col-$k]]->life = $monster_stats[$monster_tab[$row][$col-$k]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row][$col-$k]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row][$col-$k]] = "dead";
                                        $monster_stats[$monster_tab[$row][$col-$k]] = null;
                                        $monster_tab[$row][$col-$k] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row;
                                        $pj_stats[0]['col'] = $col-$k;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row][$col-$k]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row][$col-$k]->type == 'ground')
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row;
                                    $pj_stats[0]['col'] = $col-$k;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            else
                            {
                                if($monster_tab[$row][$col-$k] != null && ($map_tab[$row][$col-$k]->type == 'ground' || $map_tab[$row][$col-$k]->break == 1))
                                {
                                    if ($monster_stats[$monster_tab[$row][$col-$k]]->armor > 0)
                                    {
                                        $monster_stats[$monster_tab[$row][$col-$k]]->armor = $monster_stats[$monster_tab[$row][$col-$k]]->armor - 3000;
                                        if ($monster_stats[$monster_tab[$row][$col-$k]]->armor <= 0)
                                        {
                                            $monster_stats[$monster_tab[$row][$col-$k]]->life = $monster_stats[$monster_tab[$row][$col-$k]]->life + $monster_stats[$monster_tab[$row][$col-$k]]->armor;
                                            $monster_stats[$monster_tab[$row][$col-$k]]->armor = 0;
                                        }
                                    }
                                    else
                                    {
                                        $monster_stats[$monster_tab[$row][$col-$k]]->life = $monster_stats[$monster_tab[$row][$col-$k]]->life - 3000;
                                    }
                                    if ($monster_stats[$monster_tab[$row][$col-$k]]->life <= 0)
                                    {
                                        $monster_hit[$monster_tab[$row][$col-$k]] = "dead";
                                        $monster_stats[$monster_tab[$row][$col-$k]] = null;
                                        $monster_tab[$row][$col-$k] = null;
                                        $pj_kills++;
                                        $mv++;
                                        $pj_stats[0]['row'] = $row;
                                        $pj_stats[0]['col'] = $col-$k;
                                        if ($pj_kills >= 25)
                                        {
                                            $map_tab[5][11] = $map->getMap_tile(2);
                                            $map_tab[6][11] = $map->getMap_tile(2);
                                            $map_tab[7][11] = $map->getMap_tile(2);
                                            session()->put('map_tab', $map_tab);
                                        }
                                    }
                                    else
                                    {
                                        $monster_hit[$monster_tab[$row][$col-$k]] = "hit";
                                        break;
                                    }
                                }
                                else if($map_tab[$row][$col-$k]->type == 'ground' || $map_tab[$row][$col-$k]->break == 1)
                                {
                                    $mv++;
                                    $pj_stats[0]['row'] = $row;
                                    $pj_stats[0]['col'] = $col-$k;
                                }
                                else
                                {
                                    break;
                                }
                                if($map_tab[$row][$col-$k]->break == 1)
                                {
                                    $map_tab[5][11] = $map->getMap_tile(2);
                                    $map_tab[6][11] = $map->getMap_tile(2);
                                    $map_tab[7][11] = $map->getMap_tile(2);
                                    $wall_destroyed = true;
                                    session()->put('map_tab', $map_tab);
                                }
                            }
                        }
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 1000;
                    $pj_stats[0]->action = $pj_stats[0]->action - 10;
                    break;
                case 1:
                    if(!empty($skill_tiles_aoe))
                    {
                        foreach($skill_tiles_aoe as $aoe_tile)
                        {
                            $values = explode('_',$aoe_tile);
                            $aoe_row = $values[0];
                            $aoe_col = $values[1];
                            if($monster_tab[$aoe_row][$aoe_col] != null && $map_tab[$aoe_row][$aoe_col]->type == 'ground')
                            {
                                if($monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor > 0)
                                {
                                    $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor = $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor - ($pj_stats[0]->damage+400);
                                    if($monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor <= 0)
                                    {
                                        $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->life = $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->life + $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor;
                                        $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->armor = 0;
                                    }
                                }
                                else
                                {
                                    $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->life = $monster_stats[$monster_tab[$aoe_row][$aoe_col]]->life - ($pj_stats[0]->damage+400);
                                }
                                if($monster_stats[$monster_tab[$aoe_row][$aoe_col]]->life <=0)
                                {
                                    $monster_hit[$monster_tab[$aoe_row][$aoe_col]] ="dead";
                                    $monster_stats[$monster_tab[$aoe_row][$aoe_col]] = null;
                                    $monster_tab[$aoe_row][$aoe_col] = null;
                                    $pj_kills++;
                                    if($pj_kills >= 25)
                                    {
                                        $map_tab[5][11] = $map->getMap_tile(2);
                                        $map_tab[6][11] = $map->getMap_tile(2);
                                        $map_tab[7][11] = $map->getMap_tile(2);
                                        session()->put('map_tab', $map_tab);
                                    }
                                }
                                else
                                {
                                    $monster_hit[$monster_tab[$aoe_row][$aoe_col]] ="hit";
                                }
                            }
                        }
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 300;
                    $pj_stats[0]->action = $pj_stats[0]->action - 10;
                    break;
                case 2:
                    $id = $monster_tab[$row][$col];
                    $monster_hit[$monster_tab[$row][$col]] ="hit";
                    if(isset($buffs[$id]) && $buffs[$id]>0)
                    {
                        $buffs[$id] = 10;
                    }
                    else
                    {
                        $buffs[$id] = 10;
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 250;
                    $pj_stats[0]->action = $pj_stats[0]->action - 10;
                    break;
                case 3:
                    if(isset($buffs['pj']['sprint']) && $buffs['pj']['sprint']>0)
                    {
                        $buffs['pj']['sprint'] = 1;
                    }
                    else
                    {
                        $buffs['pj']['sprint'] = 1;
                        $pj_stats[0]->mv = $pj_stats[0]->mv + 2;
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 100;
                    break;
                case 4:
                    $pj_stats[0]->life = $pj_stats[0]->life + 1500;
                    if($pj_stats[0]->life>15000)
                    {
                        $pj_stats[0]->life = 15000;
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 200;
                    $pj_stats[0]->action = $pj_stats[0]->action - 10;
                    break;
                case 5:
                    if(isset($buffs['pj']['guillotine']) && $buffs['pj']['guillotine']>0)
                    {
                        $buffs['pj']['guillotine'] = 1;
                    }
                    else
                    {
                        $buffs['pj']['guillotine'] = 1;
                        $pj_stats[0]->damage = $pj_stats[0]->damage + 1400;
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 700;
                    break;
                case 6:
                    if(isset($buffs['pj']['defy_pain']) && $buffs['pj']['defy_pain']>0)
                    {
                        $buffs['pj']['defy_pain'] = 2;
                    }
                    else
                    {
                        $buffs['pj']['defy_pain'] = 2;
                        $pj_stats[0]->flat_dd = $pj_stats[0]->flat_dd + 300;
                    }
                    $pj_stats[0]->mana = $pj_stats[0]->mana - 400;
                    break;
                default :
                    break;
            }

            $skill_tiles_aoe = array();
            $skill_tiles = array();
            $used_skill = true;
        }



        session()->put('pj_stats', $pj_stats);
        session()->put('monster_tab', $monster_tab);
        session()->put('monster_stats', $monster_stats);
        session()->put('buffs', $buffs);
        session()->put('pj_kills', $pj_kills);
        session()->put('skill_tiles_aoe', $skill_tiles_aoe);
        session()->put('skill_tiles', $skill_tiles);

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
            'pj_kills' => $pj_kills,
            'use_skill' => $use_skill,
            'skill_tiles' => $skill_tiles,
            'skill_tiles_aoe' => $skill_tiles_aoe,
            'skill_used' => $skill_used,
            'used_skill' => $used_skill,
            'skill_id' => $skill_id,
            'buffs' => $buffs,
            'wall_destroyed' => $wall_destroyed,
        ));
    }
}
