@extends('layouts.default')

@section('content')
    <?php
        $map_tiles = explode(" ",$map->tile_set);
        $i = 0;
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