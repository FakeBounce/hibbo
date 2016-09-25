@extends('layouts.default')

@section('content')

    @php
        $row = 0;
        $monster_id = 1;
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

                    if(!(session()->has('pj_stats')))
                    {
                        if($monsters[$i] == -1)
                        {
                            $pj_stats[0] = $map->getClasse(1);
                            $pj_stats['row'] = floor($i/$map->width);
                            $pj_stats['col'] = $i%$map->width;
                        }
                    }
                    if(!(session()->has('monster_tab')) || !(session()->has('monster_stats')))
                    {
                        if($monsters[$i] > 0)
                        {
                            $monster_stats[$monster_id] = $map->getMonster($monsters[$i]);
                            $monster_stats[$monster_id]['row'] = floor($i/$map->width);
                            $monster_stats[$monster_id]['col'] = $i%$map->width;
                            $monster_tab[$row][$i%$map->width] = $monster_id;
                            $monster_id++;
                        }
                        else
                        $monster_tab[$row][$i%$map->width] = null;
                    }


                @endphp

                @if($i%$map->width == 0)
                    <div class="row">
                        <div class="col-xs-12 nomarg">
                @endif

                <img class="map_tile" id="{{ $i }}" src="{{ asset('asset/img/'. $map_tab[$row][$i%$map->width]->url) }}">

                @if($i%$map->width == $map->width-1)
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

                @if(!(session()->has('monster_tab')) || !(session()->has('monster_stats')))
                    @if($monsters[$i] > 0)
                        <img class="monster stat_tooltip" id="m_{{$monster_tab[$row][$i%$map->width]}}" data-toggle="tooltip" src="{{ asset('asset/img/monsters/'.$monster_stats[$monster_tab[$row][$i%$map->width]]->url) }}" style="margin-left:-36px;"
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
                        <img class="pj" id="pj" data-toggle="tooltip" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-left:-36px;"
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
                                            {{ $pj_stats[0]->life }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->mana }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->armor }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->damage }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->range }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->mv }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->flat_dd }}
                                </td>
                                <td>
                                    {{ $pj_stats[0]->action }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    ">
                    @endif
                @else
                    @if($monster_tab[$row][$i%$map->width] != null)
                        <img class="monster stat_tooltip" id="m_{{$monster_tab[$row][$i%$map->width]}}" data-toggle="tooltip" src="{{ asset('asset/img/monsters/'.$monster_stats[$monster_tab[$row][$i%$map->width]]->url) }}" style="margin-left:-36px;"
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
                    @if(($row == $pj_stats['row']) && ($i%$map->width == $pj_stats['col']))
                        <img class="pj" id="pj" data-toggle="tooltip" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-left:-36px;"
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
                                        {{ $pj_stats[0]->life }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->mana }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->armor }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->damage }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->range }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->mv }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->flat_dd }}
                                     </td>
                                     <td>
                                         {{ $pj_stats[0]->action }}
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                         ">
                    @endif
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
                if(!(session()->has('pj_stats')))
                    session()->put('pj_stats', $pj_stats);
            @endphp
            <div class="pull-right"><a class="btn btn-primary" href="{{ route('map.reset', ['map' => 1]) }}">Reset</a></div>
        </div>
    </div>
@endsection

@section('js')


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('[data-toggle="tooltip"]').tooltip({
            animated: 'fade',
            trigger: 'hover focus',
            placement: 'top',
            html: true
        });

        $('.map_tile,.monster').click(function(){
            if($(this).hasClass("map_tile"))
            {
                var fdata = {id:$(this).attr("id")};
            }
            else
            {
                var fdata = {mid:$(this).attr("id")};
            }
            $.ajax({
                url:"{{ route('map.action',['map'=>$map]) }}",
                type: "post",
                dataType: 'json',
                data: fdata,
                success: function(data) {
                    if(data['movable'] == "ok")
                    {
                        movement('pj',data['mv'],data['direction']);
                        update_tooltip("pj",data['pj_stats'][0],"pj");
                    }
                    else if(data['movable'] == "attack")
                    {
                        attack('pj',"m_"+parseInt(getFirstKey(data['monster_hit'])),'pj',data['direction']);
                        $.each( data['monster_hit'], function( key, value ) {
                            if(value == "hit")
                            {
                                update_tooltip("m_"+key,data['monster_stats'][key],"monster");
                            }
                            if(value == "dead")
                            {
                                $('#m_'+key).fadeOut('slow', function(){ $('#m_'+key).remove(); });

                            }
                        });
                        update_tooltip("pj",data['pj_stats'][0],"pj");
                    }

                    console.log(data);
                },
                error:function(jqXHR) {
                    console.log('Erreur chat');
                    console.log(jqXHR.responseText);
                }
            });
        });

        function update_tooltip(id, stats, type){

            if(type == "pj")
            {
                var tooltip_val = "<table class='table_stat text-center'>"+
                        "<tbody>"+
                        "<tr>"+
                        "<th> </th>"+
                        "<th>Hp</th>"+
                        "<th>Mana</th>"+
                        "<th>Ar</th>"+
                        "<th>Dmg</th>"+
                        "<th>Range</th>"+
                        "<th>Mv</th>"+
                        "<th>DD</th>"+
                        "<th>Action</th>"+
                        "</tr>"+
                        "<tr>"+
                        " <td>"+
                        "<img class='monster_stat' src='{{ asset('asset/img/classes/gface.png') }}'>"+
                        "</td>"+
                        "<td>"+
                        stats['life']+
                        "</td>"+
                        "<td>"+
                        stats['mana']+
                        "</td>"+
                        "<td>"+
                        stats['armor']+
                        "</td>"+
                        "<td>"+
                        stats['damage']+
                        "</td>"+
                        "<td>"+
                        stats['range']+
                        "</td>"+
                        "<td>"+
                        stats['mv']+
                        "</td>"+
                        "<td>"+
                        stats['flat_dd']+
                        "</td>"+
                        "<td>"+
                        stats['action']+
                        "</td>"+
                        "</tr>"+
                        "</tbody>"+
                        "</table>";

            }
            else if(type == "monster")
            {
                var tooltip_val = "<table class='table_stat text-center'>"+
                        "<tbody>"+
                        "<tr>"+
                        "<th> </th>"+
                        "<th>Hp</th>"+
                        "<th>Ar</th>"+
                        "<th>Dmg</th>"+
                        "<th>Range</th>"+
                        "<th>Mv</th>"+
                        "<th>Dr</th>"+
                        "</tr>"+
                        "<tr>"+
                        " <td>"+
                        "<img class='monster_stat' src='{{ asset('asset/img/monsters') }}/"+stats['url']+"'>"+
                        "</td>"+
                        "<td>"+
                        stats['life']+
                        "</td>"+
                        "<td>"+
                        stats['armor']+
                        "</td>"+
                        "<td>"+
                        stats['damage']+
                        "</td>"+
                        "<td>"+
                        stats['range']+
                        "</td>"+
                        "<td>"+
                        stats['mv']+
                        "</td>"+
                        "<td>"+
                        stats['dr']+
                        "</td>"+
                        "</tr>"+
                        "</tbody>"+
                        "</table>";

            }

            $('#'+id).tooltip('hide')
                    .attr('data-original-title', tooltip_val)
                    .tooltip('fixTitle')
                    .tooltip('show');
        }

        function movement(id,mv,direction)
        {
            var cont = 0;
            if(id == "pj")
                var sprite = 0;
            else
                var sprite = 2;

            if(direction == "r" || direction == "l")
            var marg = $('#'+id).css("margin-left").replace("px", "");
            if(direction == "u" || direction == "d")
            var marg = $('#'+id).css("margin-top").replace("px", "");

            var animation = setInterval( moveSprite,50);

            function moveSprite(){
                if(direction == "r")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite1.png') }}");
                    }
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite2.png') }}");
                    }
                }
                if(direction == "l")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche1.png') }}");
                    }
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche2.png') }}");
                    }
                }
                if(direction == "u")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos1.png') }}");
                    }
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos2.png') }}");
                    }
                }
                if(direction == "d")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface1.png') }}");
                    }
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface2.png') }}");
                    }
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == parseInt(mv)*17){
                    if(direction == "r")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    if(direction == "l")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    if(direction == "u")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    if(direction == "d")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    clearInterval(animation);
                }
            }
        }

        function attack(id,id2,type,direction)
        {
            var cont = 0;
            var sprite = 0;
            if(direction == "r" || direction == "l")
            {
                var marg = $('#'+id).css("margin-left").replace("px", "");
                var marg2 = $('#'+id2).css("margin-left").replace("px", "");
            }
            if(direction == "u" || direction == "d")
            {
                var marg = $('#'+id).css("margin-top").replace("px", "");
                var marg2 = $('#'+id2).css("margin-top").replace("px", "");
            }
            var animation = setInterval( moveSprite_Attack,50);

            function moveSprite_Attack(){
                if(direction == "r")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite2.png') }}");
                    }
                }
                if(direction == "l")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche2.png') }}");
                    }
                }
                if(direction == "u")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos2.png') }}");
                    }
                }
                if(direction == "d")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface2.png') }}");
                    }
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 5){
                    if(direction == "r")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    if(direction == "l")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    if(direction == "u")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    if(direction == "d")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack2,100);
                }
            }
            function moveSprite_Attack2(){
                if(direction == "r")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroitea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroitea2.png') }}");
                    }
                }
                if(direction == "l")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauchea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauchea2.png') }}");
                    }
                }
                if(direction == "u")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdosa1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdosa2.png') }}");
                    }
                }
                if(direction == "d")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gfacea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gfacea2.png') }}");
                    }
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 2){
                    if(direction == "r")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    if(direction == "l")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    if(direction == "u")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    if(direction == "d")
                    $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack3,100);
                }
            }


            function moveSprite_Attack3(){
                if(direction == "r")
                {
                    marg2 = parseInt(marg2)+2;
                    $('#'+id2).css({ "margin-left": parseInt(marg2)+"px" });
                }
                if(direction == "l")
                {
                    marg2 = parseInt(marg2)-2;
                    $('#'+id2).css({ "margin-left": parseInt(marg2)+"px" });
                }
                if(direction == "u")
                {
                    marg2 = parseInt(marg2)-2;
                    $('#'+id2).css({ "margin-top": parseInt(marg2)+"px" });
                }
                if(direction == "d")
                {
                    marg2 = parseInt(marg2)+2;
                    $('#'+id2).css({ "margin-top": parseInt(marg2)+"px" });
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 3){
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack4,10);
                }
            }

            function moveSprite_Attack4(){
                if(direction == "r")
                {
                    marg2 = parseInt(marg2)-2;
                    $('#'+id2).css({ "margin-left": parseInt(marg2)+"px" });
                }
                if(direction == "l")
                {
                    marg2 = parseInt(marg2)+2;
                    $('#'+id2).css({ "margin-left": parseInt(marg2)+"px" });
                }
                if(direction == "u")
                {
                    marg2 = parseInt(marg2)+2;
                    $('#'+id2).css({ "margin-top": parseInt(marg2)+"px" });
                }
                if(direction == "d")
                {
                    marg2 = parseInt(marg2)-2;
                    $('#'+id2).css({ "margin-top": parseInt(marg2)+"px" });
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 3){
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack5,10);
                }
            }

            function moveSprite_Attack5(){
                if(direction == "r")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroitea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    }
                }
                if(direction == "l")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauchea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    }
                }
                if(direction == "u")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdosa1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    }
                }
                if(direction == "d")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gfacea1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 2){
                    if(direction == "r")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    if(direction == "l")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    if(direction == "u")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    if(direction == "d")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack6,50);
                }
            }


            function moveSprite_Attack6(){
                if(direction == "r")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite2.png') }}");
                    }
                }
                if(direction == "l")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-left": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche2.png') }}");
                    }
                }
                if(direction == "u")
                {
                    marg = parseInt(marg)+2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos2.png') }}");
                    }
                }
                if(direction == "d")
                {
                    marg = parseInt(marg)-2;
                    $('#'+id).css({ "margin-top": parseInt(marg)+"px" });
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface1.png') }}");
                    }
                    else
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface2.png') }}");
                    }
                }
                cont++;
                if(sprite == 0)
                    sprite = 1;
                else
                    sprite = 0;

                if(cont == 5){
                    if(direction == "r")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                    if(direction == "l")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                    if(direction == "u")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                    if(direction == "d")
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    cont = 0;
                    clearInterval(animation);
                }
            }
        }

        function getFirstKey( data ) {
            for (elem in data )
                return elem;
        }

    </script>
@endsection