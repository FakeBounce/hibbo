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
                        <th data-toggle="tooltip" data-container="body" title="Votre santé. Vous mourrez si elle tombe à zéro.">Hp</th>
                        <th data-toggle="tooltip" data-container="body" title="Votre jauge d'énergie. Elle sert à utiliser des compétences.">Énergie</th>
                        <th data-toggle="tooltip" data-container="body" title="Votre armure. Vous perdez d'abord de l'armure avant de perdre votre santé.">Ar</th>
                        <th data-toggle="tooltip" data-container="body" title="Vos dégâts. Une attaque normale coute 10 actions et inflige {{ $pj_stats[0]->damage }} points de dégâts">Dmg</th>
                        <th data-toggle="tooltip" data-container="body" title="Votre portée d'attaque. 1 = une case">Range</th>
                        <th data-toggle="tooltip" data-container="body" title="Vos points de déplacement. Vous pouvez vous déplacer de {{ $pj_stats[0]->mv }} cases.">Mv</th>
                        <th data-toggle="tooltip" data-container="body" title="Votre réduction de dégâts. Vous réduisez les dégâts subis de {{ $pj_stats[0]->flat_dd }} points.">DD</th>
                        <th data-toggle="tooltip" data-container="body" title="Vos points d'actions. Une fois épuisés vous ne pouvez plus attaquer.">Actions</th>
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

            <h4>Vos compétences :</h4>
            <div class="char_skills">
                <table class='table_stat text-center'>
                    <tbody>
                    <tr>
                        <th> </th>
                    </tr>
                    <tr>
                        @foreach($skills as $key=>$skill)
                            @if($key<7)
                                <td>
                                    <img class='skill' id="sk_{{$key}}" data-toggle="tooltip" src='{{ asset('asset/img/skills/'.$skill->img) }}'
                                         title="
                                <table class='table_stat text-center'>
                                    <tbody>
                                    <tr>
                                        <th>Nom </th>
                                        <th>Description </th>
                                        <th>Effet bonus </th>
                                        <th>Coût en énergie </th>
                                        <th>Coût en action </th>
                                    </tr>
                                    <tr>
                                        <td>
                                             {{ $skill->name }}
                                                 </td>
                                                 <td>
                                                      {{ $skill->description }}
                                                 </td>
                                                 <td>
                                                      {{ $skill->bonus_description }}
                                                 </td>
                                                 <td>
                                                      {{ $skill->cost_mana }}
                                                 </td>
                                                 <td>
                                                      {{ $skill->action }}
                                                 </td>
                                             </tr>
                                             </tbody>
                                         </table>
                                         ">
                                </td>
                            @endif
                        @endforeach
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
        <div class="right_pannel col-xs-7 text-center">
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

                            <img class="map_tile {{$map_tab[$row][$i%$map->width]->type}} m_{{$row}}_{{$i%$map->width}}" id="{{ $i }}" src="{{ asset('asset/img/'. $map_tab[$row][$i%$map->width]->url) }}">

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
                                        <th>Énergie</th>
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

        $(document).on("click", '.map_tile,.monster,.red_potion,.blue_potion,.skill,.skill_tiles', function() {
            if($(this).hasClass("map_tile"))
            {
                var fdata = {id:$(this).attr("id")};
            }
            else if($(this).hasClass("left_pannel_object"))
            {
                var fdata = {item:$(this).attr("id")};
            }
            else if($(this).hasClass("skill"))
            {
                var fdata = {skill:$(this).attr("id")};
            }
            else if($(this).hasClass("skill_tiles"))
            {
                var fdata = {skill_use:$(this).attr('class').split('skill_tiles st_')};
            }
            else
            {
                var fdata = {mid:$(this).attr("id")};
            }
            $('.skill_tiles').remove();
            $('.skill_tiles_aoe').remove();
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
                        if(data['pj_kills'] >= 25)
                        {
                            $.each($(".door"), function(key, value) {
                                $(this).removeClass("door").addClass("ground").attr("src",'{{ asset('asset/img/grass.png') }}');
                            });
                        }
                        attack('pj',"m_"+parseInt(getFirstKey(data['monster_hit'])),'pj',data['direction'],data['pj_stats'][0]['damage']);
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
                    if(data['use_skill'])
                    {
                        $.each(data['skill_tiles'], function(key, value) {
                            $('.m_'+value).before('<div class="skill_tiles st_'+data['skill_used']+'_'+value+'"></div>');
                        });
                        $.each(data['skill_tiles_aoe'], function(key, value) {
                            $('.m_'+value).before('<div class="skill_tiles_aoe"></div>');
                        });
                    }
                    if(data['wall_destroyed'])
                    {
                        $.each($(".door"), function(key, value) {
                            $(this).removeClass("door").addClass("ground").attr("src",'{{ asset('asset/img/grass.png') }}');
                        });
                    }
                    if(data['used_skill'])
                    {
                        if(data['skill_id'] == 0)
                        {
                            if(data['mv']>0)
                            {
                                movement('pj',data['mv'],data['direction']);
                            }
                            update_left_pannel(data['pj_stats'][0]);
                        }
                        if(data['skill_id'] == 1)
                        {
                            $('#pj').attr("src","{{ asset('asset/img/classes/tournoiement.gif') }}");
                            setTimeout(update_pj_src,500);
                        }
                        if(data['skill_id'] == 3 ||data['skill_id'] == 4 ||data['skill_id'] == 5 ||data['skill_id'] == 6)
                        {
                            $('#pj').attr("src","{{ asset('asset/img/classes/sante-bas.gif') }}");
                            setTimeout(update_pj_src,1000);
                        }

                        if(data['pj_kills'] >= 25)
                        {
                            $.each($(".door"), function(key, value) {
                                $(this).removeClass("door").addClass("ground").attr("src",'{{ asset('asset/img/grass.png') }}');
                            });
                        }
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

                    console.log(data);
                },
                error:function(jqXHR) {
                    console.log('Erreur chat');
                    console.log(jqXHR.responseText);
                }
            });

            function update_pj_src() {
                $('#pj').attr("src","{{ asset('asset/img/classes/gface.png') }}");
            }
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
                '<tr>'+
                '<th> </th>'+
                '<th data-toggle="tooltip" data-container="body" title="Votre santé. Vous mourrez si elle tombe à zéro.">Hp</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Votre jauge d\'énergie. Elle sert à utiliser des compétences.">Énergie</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Votre armure. Vous perdez d\'abord de l\'armure avant de perdre votre santé.">Ar</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Vos dégâts. Une attaque normale coute 10 actions et inflige '+stats['damage']+' points de dégâts">Dmg</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Votre portée d\'attaque. 1 = une case">Range</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Vos points de déplacement. Vous pouvez vous déplacer de '+stats['mv']+' cases.">Mv</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Votre réduction de dégâts. Vous réduisez les dégâts subis de '+stats['flat_dd']+' points.">DD</th>'+
                '<th data-toggle="tooltip" data-container="body" title="Vos points d\'actions. Une fois épuisés vous ne pouvez plus attaquer.">Actions</th>'+
                '</tr>'+
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

            $('[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                trigger: 'hover focus',
                placement: 'top',
                html: true
            });
        }

        function update_tooltip(id, stats, type){

            if(type == "monster")
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

        function attack(id,id2,type,direction,dmg)
        {
            var marg_left = $('#'+id).css("margin-left");
            var marg_top = $('#'+id).css("margin-top");
            var marg_left2 = $('#'+id2).css("margin-left");
            var marg_top2 = $('#'+id2).css("margin-top");
            if(id != "pj")
                dmg = dmg-50;
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
            //////// Add print_dmg
            //if( !($( ".dmg_print" ).length))
            /*if(id != "pj")
            {
                var margin_top = parseInt($('#'+id2).css("margin-top"))-5;
                margin_top = margin_top + "px";
                var margin_left = parseInt($('#'+id2).css("margin-left"))-30;
                margin_left = margin_left + "px";
                $('#'+id2).before('<div class="dmg_print" style="margin-left:'+margin_left+';margin-top:'+margin_top+';"></div>');
            }
            else
            {
                $('#'+id2).before('<div class="dmg_print"></div>');
            }*/
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
                    animation = setInterval( print_dmg,75);
                }
            }

            function print_dmg()
            {
                //$('.dmg_print').append(dmg+'<br>');
                clearInterval(animation);
                animation = setInterval( moveSprite_Attack2,75);
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
                    /*if(id == "pj")
                    {
                        var margin_left = $('#'+id2).css("margin-left");
                        var margin_top = parseInt($('#'+id2).css("margin-top"))+25;
                        margin_top = margin_top + "px";
                        var health_bar = '<div class="progress" style="margin-left:'+margin_left+';margin-top:'+margin_top+';">' +
                            '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">'
                        '</div></div>';
                        $('#'+id2).before(health_bar);
                    }*/$
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

                    $('#'+id).css("margin-left",marg_left);
                    $('#'+id).css("margin-top",marg_top);
                    $('#'+id2).css("margin-left",marg_left2);
                    $('#'+id2).css("margin-top",marg_top2);
                    $(".dmg_print").remove();
                }
            }
        }

        function ia(id,monster_mv,direction,dmg){
            var animate;
            var tab_mv = monster_mv.split(",");
            $.each( tab_mv, function( key2, value2 ) {
                if(value2 == "hit")
                {
                    animate = setInterval( attack(id,'pj','monster',direction,dmg),100);
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
            $(this).disable(true);
            var end_turn = null;
            var fdata = {turn:"end"};
            $.ajax({
                url:"{{ route('map.turn',['map'=>$map]) }}",
                type: "post",
                dataType: 'json',
                data: fdata,
                success: function(data) {
                    console.log(data);
                    update_left_pannel(data['pj_stats'][0]);

                    if(data['pj_kills'] >= 25)
                    {
                        $.each($(".door"), function(key, value) {
                            $(this).removeClass("door").addClass("ground").attr("src",'{{ asset('asset/img/grass.png') }}');
                        });
                    }

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
                        ia(id,value1,direction,data['monster_stats'][key1]['damage']);
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

                    if(data['boss_heal'])
                    {
                        $('#m_23').attr("src","{{ asset('asset/img/monsters/basic_boss_anime.gif') }}");
                        setTimeout(update_boss_src,1000);
                        update_tooltip("m_23",data['monster_stats'][23],"monster");
                    }
                    setTimeout( enable_endturn,600);

                },
                error:function(jqXHR) {
                    console.log('Erreur');
                    console.log(jqXHR.responseText);
                    $('.end_turn').disable(false);
                }
            });

            function enable_endturn() {
                $('.end_turn').disable(false);
            }

            function update_boss_src() {
                $('#m_23').attr("src","{{ asset('asset/img/monsters/Basic_Boss.png') }}");
            }
        });

        function getFirstKey( data ) {
            for (elem in data )
                return elem;
        }

        jQuery.fn.extend({
            disable: function(state) {
                return this.each(function() {
                    var $this = $(this);
                    $this.toggleClass('disabled', state);
                });
            }
        });

    </script>
@endsection