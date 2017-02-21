@extends('layouts.go')

@section('content')
    <img src="{{asset('asset/img/go.gif')}}"style="
    width: 100%;
">
    <div class="text-center" style="width:100%;margin-top: -80px;font-size: 32px;"><a style="text-decoration : none; color : #fff;" href="{{ route('map.reset',['map'=>$map]) }}">Rejouer</a></div>
@endsection