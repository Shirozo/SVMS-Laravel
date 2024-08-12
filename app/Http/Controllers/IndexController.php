<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {

        $elections = DB::table("elections as e")
        ->select(DB::raw("e.id,
            e.title,
            e.scope,
            e.started,
            e.college_limit,
            e.course_limit,
            e.year_level_limit,
            c.college_name,
            cs.course_name"))
        ->leftJoin("colleges as c", "e.college_limit", "=", "c.id")
        ->leftJoin("courses as cs", "e.course_limit", "=", "cs.id")
        ->get();
                
        return view("index", [
            "elections" => $elections
        ]);

    }
}
