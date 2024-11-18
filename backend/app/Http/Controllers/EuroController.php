<?php

namespace App\Http\Controllers;

use Carbon\Exceptions\UnitNotConfiguredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EuroController extends Controller
{
    public function index(){
        $builder = DB::table("euro2024");
        $items = $builder->orderBy("nation")->paginate(6);
        $final = DB::table("euro2024")->orderByDesc("played")->take(2)->get();
        return view("euro2024.index", [
            "title" => "Fooldal", 
            "items" => $items,
            "final" => $final
        ]);
    }

    public function hungary(){
        $builder = DB::table("euro2024");
        return view("euro2024.hungary", [
            "title" => "Magyarorszag",
            "hungary" => $builder->where("nation", "Magyarország")->get()
        ]);
    }

    public function nations(){
        $contains = DB::table("euro2024")->where("nation", "like", "%ország")->orderBy("nation")->get();
        $notContains = DB::table("euro2024")->where("nation", "not like", "%ország")->orderBy("nation")->get();
        return view("euro2024.nations", [
            "title" => "Orszagok", 
            "contains" => $contains,
            "notContains" =>  $notContains
        ]);
    }

    public function groups($group){
        $teams = DB::table("euro2024")->where("group", $group)->select("nation", "won", "lost", "drawn")->get();
        return view("euro2024.groups", [
            "title" => "Csoport " . $group,
            "teams" => $teams
        ]);
    }

    public function statistics(){
        return view("euro2024.statistics", [
            "title" => "Statisztikak", 
            "avgGoals" => DB::table("euro2024")->avg("goals"),
            "minGoals" => DB::table("euro2024")->orderBy("goals")->take(1)->select("nation", "goals")->get(),
            "mostGoalsF" => DB::table("euro2024")->where("group", "F")->orderByDesc("goals")->take(1)->select("nation")->get(),
            "wonThree" => DB::table("euro2024")->where("won", ">=", 3)->count(),
            "drawnCount" => DB::table("euro2024")->where("drawn", ">=", 1)->count()
        ]);
    }
}
