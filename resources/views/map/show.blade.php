@extends('layouts.default')

@section('content')
    <?php
        $map_tiles = explode(" ",$map->tile_set);
        $monsters = explode(" ",$map->monster_set);
        $monsters_range = explode(" ",$map->monster_range);
        $i = 0; $margtop = 0;$margleft = ($map->width+1)*17*-1;
    ?>
    <div class ="row">
        <div class="col-xs-12 text-center margup">
        </div>
    </div>
    <div class ="row">
        <div class="col-xs-8 text-center">
            <h2>{{ $map->name }}</h2>
            @foreach($monsters as $monster)
                @if($monster > 0)
                    <img class="monster" src="{{ asset('asset/img/monsters/'.$map->getMonster($monster)->name.'.png') }}" style="margin-top:{{$margtop}}px;margin-left:{{$margleft}}px;">
                @endif
                @if($monster == -1)
                    <img class="pj" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-top:{{$margtop}}px;margin-left:{{$margleft}}px;">
                @endif 

                <?php
                    $i++;
                    $margleft+=34;
                ?>

                @if($i%$map->width == 0)
                    <?php
                        $margtop+=34;
                        $margleft=($map->width)*17*-1;
                    ?>
                @endif
            @endforeach

                <?php
                $i=0;
                ?>
            @foreach($map_tiles as $map_tile)
                @if($i%$map->width == 0)
                    <div class="row"><div class="col-xs-12 nomarg">
                @endif
                    <img class="map_tile" src="{{ asset('asset/img/'.$map->getMap_tile($map_tile)->url) }}">
                    <?php
                        $i++;
                    ?>
                @if($i%$map->width == 0)
                    </div></div>
                @endif
            @endforeach
        </div>
        <div class="col-xs-4 text-center">
            <h3>Stats</h3>

            <table class="table_stat text-center">
                <tbody>
                <tr>
                    <th>Img</th>
                    <th>Nom</th>
                    <th>Hp</th>
                    <th>Ar</th>
                    <th>Dmg</th>
                    <th>Range</th>
                    <th>Mv</th>
                    <th>Dr</th>
                </tr>
                @foreach($monsters_range as $monster_range)
                    <tr>
                        <td>
                            <img class="monster_stat" src="{{ asset('asset/img/monsters/'.$map->getMonster($monster_range)->name.'.png') }}">
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->name }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->life }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->armor }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->damage }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->range }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->mv }}
                        </td>
                        <td>
                        {{ $map->getMonster($monster_range)->dr }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection