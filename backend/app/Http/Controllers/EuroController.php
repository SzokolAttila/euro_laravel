<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EuroController extends Controller
{
    public function index(){
        $builder = DB::table("euro2024");
        return view("euro2024.index", [
            "title" => "Fooldal", 
            "items" => ,
            "final" => 
        ]);
    }
}
