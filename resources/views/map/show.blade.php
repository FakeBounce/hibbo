@extends('layouts.default')

@section('content')
    <?php
        $map_tiles = explode(" ",$map->tile_set);
        $monsters = explode(" ",$map->monster_set);
        $i = 0; $margtop = 0;$margleft = ($map->width+1)*17*-1-2;
            echo $margleft;
    ?>
    <div class ="row">
        <div class="col-xs-12 text-center margup">
            <h2>{{ $map->name }}</h2>
        </div>
    </div>
    <div class ="row">
        <div class="col-xs-2 text-center">
            Stats
        </div>
        <div class="col-xs-8 text-center">

            @foreach($monsters as $monster)
                @if($monster > 0)
                    <img class="monster" src="{{ asset('asset/img/monsters/'.$map->getMonster($monster)['name'].'.png') }}" style="margin-top:{{$margtop}}px;margin-left:{{$margleft}}px;">
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
                        $margleft=($map->width)*17*-1-2;
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
                    <img class="map_tile" src="{{ asset('asset/img/'.$map->getMap_tile($map_tile)['url']) }}">
                    <?php
                        $i++;
                    ?>
                @if($i%$map->width == 0)
                    </div></div>
                @endif
            @endforeach
        </div>
        <div class="col-xs-2 text-center">
            Stats
        </div>
    </div>
@endsection