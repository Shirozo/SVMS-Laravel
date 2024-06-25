<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\Election;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ElectionsController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $courses = Course::all();

        $elections = DB::table('elections')
            ->select(DB::raw("elections.id,
                elections.title,
                elections.scope,
                elections.started,
                elections.year_level_limit,
                colleges.college_name AS college_limit,
                courses.course_name AS course_limit"))
            ->leftJoin("courses", "courses.id", "=", "elections.course_limit")
            ->leftJoin("colleges", "colleges.id", "=", "elections.college_limit")
            ->get();

        return view('elections', [
            "elections" => $elections,
            "colleges" => $colleges,
            "courses" => $courses
        ]);
    }

    public function store(Request $request)
    {

        $valid = Validator::make($request->all(), [
            "title" => "required|max:50",
            "scope" => "required|in:1,2,3"
        ]);

        if ($valid->fails()) {
            toastr("Invalid Form", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }

        $college = $request->college_limit;
        $course = $request->course_limit;
        $year = $request->year_limit;
        if ($request->scope == 1) {
            if ($request->college_limit != null || $request->course_limit != null || $request->year_limit != null) {
                toastr("Invalid Form", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        } elseif ($request->scope == 2) {
            if ($request->college_limit == null || $request->course_limit != null || $request->year_limit != null) {
                toastr("College Scope is required", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        } elseif ($request->scope == 3) {
            if ($request->college_limit != null || $request->course_limit == null || $request->year_limit == null) {
                toastr("Invalid Form", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        } else {
            toastr("Action Not Allowed!", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }

        $new_election = Election::create([
            "title" => $request->title,
            "scope" => $request->scope,
            "college_limit" => $college,
            "course_limit" => $course,
            "year_level_limit" => $year
        ]);

        toastr("New Election Added!", Type::SUCCESS);
        return redirect()->route('elections.index');
    }
}
