@extends('layouts.default')

@section('content')
    <?php
        $map_tiles = explode(" ",$map->tile_set);
        $monsters = explode(" ",$map->monster_set);
        $items = explode(" ",$map->item_set);
        $monsters_range = explode(" ",$map->monster_range);
        $i = 0;
    ?>

    <div class ="row">
        <div class="col-xs-12 text-center margup">
        </div>
    </div>
    <div class ="row">
        <div class="col-xs-12 text-center">
            <h2>{{ $map->name }}</h2>
            @for($i=0;$i<count($map_tiles);$i++)


                @if($i%$map->width == 0)
                    <div class="row">
                        <div class="col-xs-12 nomarg">
                @endif
                            <img class="map_tile" src="{{ asset('asset/img/'.$map->getMap_tile($map_tiles[$i])->url) }}">
                @if($i%$map->width < $i%$map->width-1)
                        </div>
                    </div>
                @endif

                @if($monsters[$i] > 0)
                    <img class="monster stat_tooltip" data-toggle="tooltip" src="{{ asset('asset/img/monsters/'.$map->getMonster($monsters[$i])->name.'.png') }}" style="margin-left:-34px;"
                    title="
                        <table class='table_stat text-center'>
                            <tbody>
                                <tr>
                                    <th>Img</th>
                                    <th>Hp</th>
                                    <th>Ar</th>
                                    <th>Dmg</th>
                                    <th>Range</th>
                                    <th>Mv</th>
                                    <th>Dr</th>
                                </tr>
                                <tr>
                                    <td>
                                        <img class='monster_stat' src='{{ asset('asset/img/monsters/'.$map->getMonster($monsters[$i])->name.'.png') }}'>
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->life }}
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->armor }}
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->damage }}
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->range }}
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->mv }}
                                    </td>
                                    <td>
                                        {{ $map->getMonster($monsters[$i])->dr }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        ">
                @endif
                @if($monsters[$i] == -1)
                    <img class="pj" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-left:-34px;">
                @endif
            @endfor
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('[data-toggle="tooltip"]').tooltip({
            animated: 'fade',
            placement: 'top',
            html: true
        });
    </script>
@endsection