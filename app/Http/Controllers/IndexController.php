<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {

        if (Auth::user()->user_type == 1) {
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
                ->where("started", "=", true)
                ->get();
        } else {
            if (Auth::user()->ssc) {
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
                    ->where(
                        [
                            ["scope", "=", "1"],
                            ["started", "=", true]
                        ]
                    )
                    ->get();
            } else {

                $courseSubquery = DB::table('courses')
                    ->select('id')
                    ->where('college_id', Auth::user()->scope);

                $elections = Election::select(
                    'elections.id',
                    'elections.title',
                    'elections.scope',
                    'elections.started',
                    'elections.college_limit',
                    'elections.course_limit',
                    'c.college_name',
                    'cs.course_name',
                    'elections.year_level_limit'
                )
                    ->leftJoin('colleges as c', 'elections.college_limit', '=', 'c.id')
                    ->leftJoin('courses as cs', 'elections.course_limit', '=', 'cs.id')
                    ->where('elections.college_limit', Auth::user()->scope)
                    ->orWhereIn('elections.course_limit', $courseSubquery)
                    ->get();
            }
        }


        return view("index", [
            "elections" => $elections
        ]);
    }
}
