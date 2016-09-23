@extends('layouts.default')

@section('content')

    @php
        $row = 0;
        $monster_id = 0;
    @endphp
    <div class ="row">
        <div class="col-xs-12 text-center margup">
        </div>
    </div>
    <div class ="row">
        <div class="col-xs-12 text-center">
            <h2>{{ $map->name }}</h2>
            @for($i=0;$i<count($map_tiles);$i++)

                @php
                    if(!(session()->has('map_tab')))
                        $map_tab[$row][$i%$map->width] = $map->getMap_tile($map_tiles[$i]);

                    if(!(session()->has('item_tab')))
                        $item_tab[$row][$i%$map->width] = $map->getItem($items[$i]);

                    if(!(session()->has('monster_tab')) || !(session()->has('monster_stats')))
                    {
                        if($monsters[$i] > 0)
                        {
                            $monster_stats[$monster_id] = $map->getMonster($monsters[$i]);
                            $monster_tab[$row][$i%$map->width] = $monster_id;
                            $monster_id++;
                        }
                        else if($monsters[$i] == -1)
                        $monster_tab[$row][$i%$map->width] = $map->getClasse(1);
                        else
                        $monster_tab[$row][$i%$map->width] = null;
                    }

                @endphp

                @if($i%$map->width == 0)
                    <div class="row">
                        <div class="col-xs-12 nomarg">
                @endif

                <img class="map_tile" src="{{ asset('asset/img/'. $map_tab[$row][$i%$map->width]->url) }}">

                @if($i%$map->width < $i%$map->width-1)
                        </div>
                    </div>
                @endif

                @if($items[$i]>0)
                    @if($items[$i] == 1)
                        <img class="object" data-toggle="tooltip" src="{{ asset('asset/img/equipements/'.$item_tab[$row][$i%$map->width]->url) }}" title="Restaure la santé à 100%">
                    @else
                        <img class="object" data-toggle="tooltip" src="{{ asset('asset/img/equipements/'.$item_tab[$row][$i%$map->width]->url) }}" title="Restaure l'énergie à 100%">
                    @endif
                @endif


                @if($monsters[$i] > 0)
                    <img class="monster stat_tooltip" data-toggle="tooltip" src="{{ asset('asset/img/monsters/'.$monster_stats[$monster_tab[$row][$i%$map->width]]->url) }}" style="margin-left:-36px;"
                    title="
                        <table class='table_stat text-center'>
                            <tbody>
                                <tr>
                                    <th> </th>
                                    <th>Hp</th>
                                    <th>Ar</th>
                                    <th>Dmg</th>
                                    <th>Range</th>
                                    <th>Mv</th>
                                    <th>Dr</th>
                                </tr>
                                <tr>
                                    <td>
                                        <img class='monster_stat' src='{{ asset('asset/img/monsters/'.$monster_stats[$monster_tab[$row][$i%$map->width]]->url) }}'>
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->life }}
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->armor }}
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->damage }}
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->range }}
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->mv }}
                                    </td>
                                    <td>
                                        {{ $monster_stats[$monster_tab[$row][$i%$map->width]]->dr }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        ">
                @endif
                @if($monsters[$i] == -1)
                    <img class="pj" data-toggle="tooltip" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-left:-36px;"
                         title="
                        <table class='table_stat text-center'>
                            <tbody>
                                <tr>
                                    <th> </th>
                                    <th>Hp</th>
                                    <th>Mana</th>
                                    <th>Ar</th>
                                    <th>Dmg</th>
                                    <th>Range</th>
                                    <th>Mv</th>
                                    <th>DD</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td>
                                        <img class='monster_stat' src='{{ asset('asset/img/classes/gface.png') }}'>
                                    </td>
                                    <td>
                                        {{ $map->getClasse(1)->life }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->mana }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->armor }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->damage }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->range }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->mv }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->flat_dd }}
                            </td>
                            <td>
                                {{ $map->getClasse(1)->action }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                ">
                @endif
                @php
                    if(($i+1)%$map->width == 0)
                    $row++;
                @endphp
            @endfor
            @php
                if(!(session()->has('map_tab')))
                    session()->put('map_tab', $map_tab);
                if(!(session()->has('item_tab')))
                    session()->put('item_tab', $item_tab);
                if(!(session()->has('monster_stats')))
                    session()->put('monster_stats', $monster_stats);
                if(!(session()->has('monster_tab')))
                    session()->put('monster_tab', $monster_tab);
            @endphp
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