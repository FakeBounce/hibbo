<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 10/09/2016
 * Time: 20:44
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     *
     */
    public function index(){

        return view('index', ["test" => "test1"]);
    }
}