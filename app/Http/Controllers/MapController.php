<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Map;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function show(Map $map){
        return view('map/show', ["map" => $map]);
    }
}
