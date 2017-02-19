@extends('layouts.default')

@section('content')

    @php
        $row = 0;
        $monster_id = 1;
        if(!(session()->has('pj_stats')))
        {
            $pj_stats[0] = $map->getClasse(1);
        }
        if(!empty($item_possessed))
        $total_items = count($item_possessed);
        $blue_pot = 2;
        $red_pot = 2;
    @endphp
    <div class ="row">
        <div class="col-xs-12 text-center margup">
        </div>
    </div>
    <div class ="row">
        <div class="left_pannel col-xs-5 text-center">
            <h3>Statistiques et objets</h3>
            <br>
            <h4>Votre personnage :</h4>
            <div class="char_stats">
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
            </div>

            <h4>Vos objets :</h4>
            <div class="char_items">
                @if(!empty($item_possessed))
                    @foreach($item_possessed as $key=>$item)
                        @if($item == 1)
                            @php
                                $red_pot --;
                            @endphp
                            <img class="left_pannel_object red_potion" id="item_{{$key}}" data-toggle="tooltip" src="{{ asset('asset/img/equipements/redpotion.png') }}" title="Restaure la santé à 100%">
                        @elseif($item == 2)
                            @php
                                $blue_pot --;
                            @endphp
                            <img class="left_pannel_object blue_potion" id="item_{{$key}}" data-toggle="tooltip" src="{{ asset('asset/img/equipements/bluepotion.png') }}" title="Restaure l'énergie à 100%">
                        @elseif($item == -1)
                            @php
                                $red_pot --;
                            @endphp
                            <img class="left_pannel_object used_potion" data-toggle="tooltip" src="{{ asset('asset/img/equipements/usedpotion.png') }}" title="Potion vide">
                        @elseif($item == -2)
                            @php
                                $blue_pot --;
                            @endphp
                            <img class="left_pannel_object used_potion" data-toggle="tooltip" src="{{ asset('asset/img/equipements/usedpotion.png') }}" title="Potion vide">
                        @endif
                    @endforeach
                @endif
                @for($i=0;$i<$red_pot;$i++)
                        <img class="left_pannel_object nred_potion" data-toggle="tooltip" src="{{ asset('asset/img/equipements/nredpotion.png') }}" title="Restaure la santé à 100%">
                @endfor
                @for($i=0;$i<$blue_pot;$i++)
                        <img class="left_pannel_object nblue_potion" data-toggle="tooltip" src="{{ asset('asset/img/equipements/nbluepotion.png') }}" title="Restaure l'énergie à 100%">
                @endfor
            </div>
        </div>
        <div class="col-xs-7 text-center">
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
                            $pj_stats[0]['row'] = floor($i/$map->width);
                            $pj_stats[0]['col'] = $i%$map->width;
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

                            <img class="map_tile {{$map_tab[$row][$i%$map->width]->type}}" id="{{ $i }}" src="{{ asset('asset/img/'. $map_tab[$row][$i%$map->width]->url) }}">

                            @if($i%$map->width == $map->width-1)
                        </div>
                    </div>
                @endif

                @if($items[$i]>0 && $item_tab[$row][$i%$map->width] != null)
                    @if($items[$i] == 1)
                        <img class="object o_{{$row}}_{{$i%$map->width}}" data-toggle="tooltip" src="{{ asset('asset/img/equipements/'.$item_tab[$row][$i%$map->width]->url) }}" title="Restaure la santé à 100%">
                    @else
                        <img class="object o_{{$row}}_{{$i%$map->width}}" data-toggle="tooltip" src="{{ asset('asset/img/equipements/'.$item_tab[$row][$i%$map->width]->url) }}" title="Restaure l'énergie à 100%">
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
                    @if(($row == $pj_stats[0]['row']) && ($i%$map->width == $pj_stats[0]['col']))
                        <img class="pj" id="pj" src="{{ asset('asset/img/classes/gface.png') }}" style="margin-left:-36px;">
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
            <div class="pull-right"><a class="btn btn-primary" href="{{ route('map.reset', ['map' => $map]) }}">Reset</a></div>
            <div class="text-center"><a class="btn btn-primary end_turn">Fin de tour</a></div>
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

        $(document).on("click", '.map_tile,.monster,.red_potion,.blue_potion', function() {
            if($(this).hasClass("map_tile"))
            {
                var fdata = {id:$(this).attr("id")};
            }
            else if($(this).hasClass("left_pannel_object"))
            {
                var fdata = {item:$(this).attr("id")};
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
                        update_left_pannel(data['pj_stats'][0]);
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
                                $('#m_'+key).tooltip('hide');
                                $('#m_'+key).fadeOut('slow', function(){ $('#m_'+key).remove(); });

                            }
                        });
                        update_left_pannel(data['pj_stats'][0]);
                    }
                    if(data['item_to_delete'])
                    {
                        $(".o_"+data['item_to_delete']).remove();
                        update_left_pannel(data['pj_stats'][0]);
                        update_potion_pannel(data['item_possessed'][data['item_possessed'].length-1],data['item_possessed'].length-1);
                    }
                    if(data['update_left_pannel'])
                    {
                        update_left_pannel(data['pj_stats'][0]);
                        update_potion_pannel(data['item_possessed'][data['item_possessed'].length-1],data['item_possessed'].length-1);
                    }

                    console.log(data);
                },
                error:function(jqXHR) {
                    console.log('Erreur chat');
                    console.log(jqXHR.responseText);
                }
            });
        });

        function update_potion_pannel(potion,length) {
            if(potion == 1)
            {
                $('.nred_potion:first').attr('src','{{ asset('asset/img/equipements/redpotion.png') }}').attr("id","item_"+length).addClass('red_potion').removeClass('nred_potion');
            }
            if(potion == 2)
            {
                $('.nblue_potion:first').attr('src','{{ asset('asset/img/equipements/bluepotion.png') }}').attr("id","item_"+length).addClass('blue_potion').removeClass('nblue_potion');
            }
            if(potion == -1)
            {
                $('.red_potion:first').attr('src','{{ asset('asset/img/equipements/usedpotion.png') }}').attr("id","").addClass('used_potion').removeClass('red_potion');
            }
            if(potion == -2)
            {
                $('.blue_potion:first').attr('src','{{ asset('asset/img/equipements/usedpotion.png') }}').attr("id","").addClass('used_potion').removeClass('blue_potion');
            }
        }

        function update_left_pannel(stats){
            var left_pannel_val = "<table class='table_stat text-center'>"+
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
                "<th>Actions</th>"+
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

            $('.char_stats').html(left_pannel_val);

        }

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
                    "<th>Actions</th>"+
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

            var animation = setInterval( moveSprite,25);

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
                if(cont%8 == 0)
                {
                    if(sprite == 0)
                        sprite = 1;
                    else if(sprite == 1)
                        sprite = 0;
                }

                if(cont == parseInt(mv)*17){
                    if(id == 'pj'){
                        if(direction == "r")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                        if(direction == "l")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                        if(direction == "u")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                        if(direction == "d")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                    clearInterval(animation);
                }
            }
        }

        function attack(id,id2,type,direction)
        {
            var cont = 0;

            if(type == 'pj')
                var sprite = 0;
            else
                var sprite = 2;
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
            var animation = setInterval( moveSprite_Attack,25);

            function moveSprite_Attack(){
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
                if(cont%8 == 0)
                {
                    if(sprite == 0)
                        sprite = 1;
                    else if(sprite == 1)
                        sprite = 0;
                }

                if(cont == 5){
                    if(id == 'pj'){
                        if(direction == "r")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                        if(direction == "l")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                        if(direction == "u")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                        if(direction == "d")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack2,50);
                }
            }
            function moveSprite_Attack2(){
                if(direction == "r")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroitea1.png') }}");
                    }
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gfacea2.png') }}");
                    }
                }
                cont++;
                if(cont%8 == 0)
                {
                    if(sprite == 0)
                        sprite = 1;
                    else if(sprite == 1)
                        sprite = 0;
                }
                if(cont == 2){
                    if(id == 'pj')
                    {
                        if(direction == "r")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                        if(direction == "l")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                        if(direction == "u")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                        if(direction == "d")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack3,50);
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

                if(cont == 3){
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack4,5);
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
                if(cont == 3){
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack5,5);
                }
            }

            function moveSprite_Attack5(){
                if(direction == "r")
                {
                    if(sprite == 0)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gdroitea1.png') }}");
                    }
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                }
                cont++;
                if(cont%8 == 0)
                {
                    if(sprite == 0)
                        sprite = 1;
                    else if(sprite == 1)
                        sprite = 0;
                }

                if(cont == 2){
                    if(id == 'pj') {
                        if (direction == "r")
                            $('#' + id).attr("src", "{{ asset('asset/img/classes/gdroite.png') }}");
                        if (direction == "l")
                            $('#' + id).attr("src", "{{ asset('asset/img/classes/ggauche.png') }}");
                        if (direction == "u")
                            $('#' + id).attr("src", "{{ asset('asset/img/classes/gdos.png') }}");
                        if (direction == "d")
                            $('#' + id).attr("src", "{{ asset('asset/img/classes/gface.png') }}");
                    }
                    cont = 0;
                    clearInterval(animation);
                    animation = setInterval( moveSprite_Attack6,25);
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
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
                    else if(sprite == 1)
                    {
                        $('#'+id).attr("src","{{ asset('asset/img/classes/gface2.png') }}");
                    }
                }
                cont++;
                if(cont%8 == 0)
                {
                    if(sprite == 0)
                        sprite = 1;
                    else if(sprite == 1)
                        sprite = 0;
                }

                if(cont == 5){
                    if(id == 'pj')
                    {
                        if(direction == "r")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdroite.png') }}");
                        if(direction == "l")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/ggauche.png') }}");
                        if(direction == "u")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gdos.png') }}");
                        if(direction == "d")
                            $('#'+id).attr("src","{{ asset('asset/img/classes/gface.png') }}");
                    }
                    cont = 0;
                    clearInterval(animation);
                }
            }
        }

        function ia(id,monster_mv,direction){
            var animate;
            var tab_mv = monster_mv.split(",");
            $.each( tab_mv, function( key2, value2 ) {
                if(value2 == "hit")
                {
                    animate = setInterval( attack(id,'pj','monster',direction),100);
                }
                else if(value2 =="l" || value2 =="r"|| value2 =="u"|| value2 =="d")
                {
                    var marg = $('#'+id).css("margin-left").replace("px", "");
                    var marg2 = $('#'+id).css("margin-top").replace("px", "");
                    if(value2 =="l")
                    {
                        $('#'+id).css({ "margin-left": (parseInt(marg)-34)+"px" });
                    }
                    if(value2 =="r")
                    {
                        $('#'+id).css({ "margin-left": (parseInt(marg)+34)+"px" });
                    }
                    if(value2 =="u")
                    {
                        $('#'+id).css({ "margin-top": (parseInt(marg2)-34)+"px" });
                    }
                    if(value2 =="d")
                    {
                        $('#'+id).css({ "margin-top": (parseInt(marg2)+34)+"px" });
                    }
                }
            });
            clearInterval(animate);
        }

        $('.end_turn').click(function(){
            var fdata = {turn:"end"};
            $.ajax({
                url:"{{ route('map.turn',['map'=>$map]) }}",
                type: "post",
                dataType: 'json',
                data: fdata,
                success: function(data) {
                    console.log(data);
                    update_left_pannel(data['pj_stats'][0]);
                    $.each( data['monster_mv'], function( key1, value1 ) {

                        var direction = "";
                        if(data['monster_stats'][key1]['row']<data['pj_stats'][0]['row'])
                        {
                            direction = "d";
                        }
                        else if(data['monster_stats'][key1]['row']>data['pj_stats'][0]['row'])
                        {
                            direction = "u";
                        }
                        else if(data['monster_stats'][key1]['col']<data['pj_stats'][0]['col'])
                        {
                            direction = "r";
                        }
                        else if(data['monster_stats'][key1]['col']>data['pj_stats'][0]['col'])
                        {
                            direction = "l";
                        }
                        var id = 'm_'+key1;
                        $('#'+id).tooltip('hide');
                        $('#pj').tooltip('hide');
                        //var tab_mv = value1.split(",");
                        ia(id,value1,direction);
                        /*$.each( tab_mv, function( key2, value2 ) {
                         if(value2 == "hit")
                         {
                         ia(id,'pj',0,'monster',direction);
                         }
                         else if(value2 =="l" || value2 =="r"|| value2 =="u"|| value2 =="d")
                         {
                         ia(id,0,1,'monster',direction);
                         }
                         });*/
                    });
                },
                error:function(jqXHR) {
                    console.log('Erreur');
                    console.log(jqXHR.responseText);
                }
            });
        });

        function getFirstKey( data ) {
            for (elem in data )
                return elem;
        }

    </script>
@endsection