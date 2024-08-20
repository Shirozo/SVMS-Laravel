<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\College;
use App\Models\Course;
use App\Models\Election;
use App\Models\ElectionData;
use App\Models\Position;
use App\Models\User;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ElectionsController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $courses = Course::all();

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
                    'elections.year_level_limit')
                    ->leftJoin('colleges as c', 'elections.college_limit', '=', 'c.id')
                    ->leftJoin('courses as cs', 'elections.course_limit', '=', 'cs.id')
                    ->where('elections.college_limit', Auth::user()->scope)
                    ->orWhereIn('elections.course_limit', $courseSubquery)
                    ->get();
            }
        }

        return view('elections', [
            "elections" => $elections,
            "colleges" => $colleges,
            "courses" => $courses
        ]);
    }

    public function show($id, Request $request)
    {
        $election = Election::find($id);
        $data = ElectionData::where("election_id", "=", $id);
        if ($data === null || $election === null) {
            toastr("Can't find election!", Type::ERROR);
            return redirect()->route("elections.index");
        }

        $voters = ElectionData::where("election_id", "=", $id)->get();

        $positions = Position::all();

        $candidates = DB::table("candidates")
            ->select(DB::raw("candidates.id, candidates.fullname, positions.name as position_name, candidates.election_id"))
            ->join("positions", "candidates.position_id", "positions.id")
            ->where("candidates.election_id", "=", $id)
            ->get();

        return view("election_information", [
            "data" => $data,
            "election" => $election,
            "voters" => $voters,
            "positions" => $positions,
            "candidates" => $candidates
        ]);
    }

    public function store(Request $request)
    {

        $valid = Validator::make($request->all(), [
            "title" => "required|max:50",
            "scope" => "required|in:1,2,3"
        ]);

        if ($valid->fails()) {
            return response()->json([
                "message" => "Invalid Form!"
            ], 403);
        }

        $college = $request->college_limit;
        $course = $request->course_limit;
        $year = $request->year_limit;
        if ($request->scope == 1) {
            if ($request->college_limit != null || $request->course_limit != null || $request->year_limit != null) {
                return response()->json([
                    "message" => "Invalid Form!"
                ], 403);
            }
        } elseif ($request->scope == 2) {
            if ($request->college_limit == null || $request->course_limit != null || $request->year_limit != null) {
                return response()->json([
                    "message" => "College Scope is required"
                ], 403);
            }
        } elseif ($request->scope == 3) {
            if ($request->college_limit != null || $request->course_limit == null || $request->year_limit == null) {
                return response()->json([
                    "message" => "Invalid Form!"
                ], 403);
            }
        } else {
            return response()->json([
                "message" => "Action Not Allowed!"
            ], 403);
        }

        $new_election = Election::create([
            "title" => $request->title,
            "scope" => $request->scope,
            "college_limit" => $college,
            "course_limit" => $course,
            "year_level_limit" => $year
        ]);

        return response()->json([
            "message" => "Retrieving Voter for Election!",
            "id" => $new_election->id
        ], 200);
    }

    public function destroy(Request $request)
    {
        if ($request->has("elec_del_id")) {
            $id = $request->elec_del_id;
            $data = Election::find($id);

            if ($data != null) {
                $data->delete();
                toastr("Election Deleted!", Type::SUCCESS);
            } else {
                toastr("Election Don't Exist!", Type::ERROR);
            }
        } else {
            toastr("Invalid Action!", Type::ERROR);
        }


        return redirect()->route("elections.index");
    }

    public function update($action, $id)
    {

        $data = Election::find($id);

        if ($data != null && $action != null) {

            if ($action === "start") {
                $data->update([
                    "started" => true
                ]);
                toastr("Election Started!", Type::SUCCESS);
            } elseif ($action === "stop") {
                $data->update([
                    "started" => false
                ]);
                toastr("Election Stopped!", Type::SUCCESS);
            } else {
                toastr("Invalid Action!", Type::ERROR);
            }
        } else {
            toastr("Election Don't Exist!", Type::ERROR);
        }



        return redirect()->route("elections.index");
    }

    public function find(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $datas = ElectionData::search($term)->limit(5)->get();

        $formatted_data = [];

        foreach ($datas as $data) {
            $formatted_data[] = ['id' => $data->voter_id, 'text' => $data->voter_name];
        }

        return response()->json($formatted_data);
    }
}
