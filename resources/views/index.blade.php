@extends('layouts.default')

@section('content')
    <div class ="row">
        <div class="col-xs-12 text-center margup">
            <h2>Choisissez une classe</h2>
        </div>
    </div>
    <div class ="row">
        <div class="col-xs-3 text-center">
            <a class="" href="{{ route('map.reset', ['map' => 1]) }}">
                <img class="img-responsive" src="{{ asset('asset/img/Warrior.png') }}">
                <h2>Guerrier</h2>
            </a>
        </div>
        <div class="col-xs-3 text-center">
                <img class="img-responsive" src="{{ asset('asset/img/Warrior_wb.png') }}">
                <h2>Indisponible</h2>
        </div>
        <div class="col-xs-3 text-center">
                <img class="img-responsive" src="{{ asset('asset/img/Warrior_wb.png') }}">
                <h2>Indisponible</h2>
        </div>
        <div class="col-xs-3 text-center">
                <img class="img-responsive" src="{{ asset('asset/img/Warrior_wb.png') }}">
                <h2>Indisponible</h2>
        </div>
    </div>
@endsection