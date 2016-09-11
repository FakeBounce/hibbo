@extends('layouts.default')

@section('content')
    <div class="container">
        <div class ="row">
            <div class="col-xs-12 text-center margup">
                <h2>Choisis ton héro</h2>
            </div>
        </div>
        <div class ="row">
            <div class="col-xs-3 text-center">
                <img class="img-responsive" src="{{ asset('asset/img/Warrior.png') }}">
                <h2>Guerrier</h2>
            </div>
        </div>
    </div>
@endsection