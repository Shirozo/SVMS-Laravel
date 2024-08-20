<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionData;
use App\Models\Vote;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{

    public function show($id, Request $request)
    {

        $data = DB::table("election_data")
            ->select()
            ->where(
                [
                    ["voter_id", "=", Auth::user()->id],
                    ["election_id", "=", $id],
                    ['has_voted', "=", false]
                ]
            )
            ->first();

        if ($data == null) {
            toastr("Not Allowed!!", Type::ERROR);
            return redirect()->route("ballot.voter");
        }

        $new_data = [];
        $max_vote = [];

        $election = Election::find($id);

        $candidates =
            DB::table('candidates')
            ->select(
                'candidates.id',
                'candidates.bio',
                'candidates.photo',
                'candidates.fullname',
                'candidates.votes',
                'positions.name as position_name',
                'positions.max_vote as max_vote',
                'positions.priority as priority',
                'positions.exclusive as exclusive',
                'users.course_id as course_id',
                'users.year as year',
                'colleges.id as college_id'
            )
            ->join('positions', 'candidates.position_id', '=', 'positions.id')
            ->join('users', 'candidates.user_id', '=', 'users.id')
            ->join('colleges', function ($join) {
                $join->on('colleges.id', '=', DB::raw('(select college_id from courses where id = users.course_id)'));
            })
            ->where("candidates.election_id", "=", $id)
            ->orderBy("priority")
            ->orderBy("fullname")
            ->get();

        $c = null;
        foreach ($candidates as $cand) {
            if ($cand->position_name !== $c) {
                $new_data[$cand->position_name] = [];
                $max_vote[$cand->position_name] = $cand->max_vote;
                $c = $cand->position_name;
            }

            if ($cand->exclusive == 1) {
                $result = DB::table('users')
                    ->select('users.course_id as course_id', 'colleges.id as college')
                    ->join('colleges', function ($join) {
                        $join->on('colleges.id', '=', DB::raw("(select college_id from courses where id = users.course_id)"));
                    })
                    ->where('users.id', Auth::user()->id)
                    ->first();

                if ($election->scope == 1) {
                    if ($result->college == $cand->college_id) {
                        $new_data[$c][] = [
                            "c_name" => $cand->fullname,
                            "c_id" => $cand->id,
                            "c_bio" => $cand->bio,
                            "c_photo" => $cand->photo,
                            "c_course" => $cand->course_id,
                            "c_course" => $cand->college_id
                        ];
                    }
                } elseif ($election->scope == 2) {
                    if ($result->college == $cand->college_id && $result->course_id == $cand->course_id && $cand->year == Auth::user()->year) {
                        $new_data[$c][] = [
                            "c_name" => $cand->fullname,
                            "c_id" => $cand->id,
                            "c_bio" => $cand->bio,
                            "c_photo" => $cand->photo,
                            "c_course" => $cand->course_id,
                            "c_course" => $cand->college_id
                        ];
                    }
                }
            } else {
                $new_data[$c][] = [
                    "c_name" => $cand->fullname,
                    "c_id" => $cand->id,
                    "c_bio" => $cand->bio,
                    "c_photo" => $cand->photo,
                    "c_course" => $cand->course_id,
                    "c_course" => $cand->college_id
                ];
            }
        }



        return view('ballot', [
            "candidates" => $new_data,
            "max_vote" => $max_vote,
            "election" => $election,
        ]);
    }

    public function store($id, $u_id, Request $request)
    {
        if (Auth::id() != $u_id) {
            toastr("Not Allowed!!", Type::ERROR);
            return redirect()->back();
        }

        $user_data = ElectionData::where(
            [
                ["election_id", "=", $id],
                ["voter_id", "=", $u_id]
            ]
        )->first();

        if ($user_data == null) {
            toastr("Not Allowed!!", Type::ERROR);
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $positions = DB::table("candidates")
                ->select(DB::raw("
                distinct(positions.name),
                positions.max_vote as max_vote
            "))
                ->join("positions", "candidates.position_id", "=", "positions.id")
                ->where("candidates.election_id", "=", $id)
                ->get();

            foreach ($positions as $p) {
                $key = str_replace(" ", "_", (string)$p->name);
                $data = $request->$key;
                if ($p->max_vote === 1) {
                    $candidate_data = Candidate::find($request->$key);
                    if ($candidate_data) {
                        if ($candidate_data->election_id != $id) {
                            DB::rollBack();
                            toastr("Form Validation Failed!", Type::ERROR);
                            return redirect()->back();
                        }

                        $candidate_data->update([
                            "votes" => $candidate_data->votes + 1
                        ]);

                        Vote::create([
                            "user_id" => $u_id,
                            "election_id" => $id,
                            "candidate_id" => $candidate_data->id
                        ]);
                    }
                } else {
                    foreach ($data as $d) {
                        $candidate_data = Candidate::find($d);
                        if ($candidate_data->election_id != $id) {
                            DB::rollBack();
                            toastr("Form Validation Failed!", Type::ERROR);
                            return redirect()->back();
                        }

                        $candidate_data->update([
                            "votes" => $candidate_data->votes + 1
                        ]);

                        Vote::create([
                            "user_id" => $u_id,
                            "election_id" => $id,
                            "candidate_id" => $candidate_data->id
                        ]);
                    }
                }
            }



            $user_data->update([
                "has_voted" => true
            ]);

            DB::commit();
            toastr("Vote Casted!", Type::SUCCESS);
            return redirect()->route("ballot.voter");
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr($th, Type::ERROR);
            return redirect()->back();
        }
    }

    public function voter(Request $request)
    {

        $userCourse = DB::table('courses')
            ->select('college_id')
            ->where('id', Auth::user()->course_id)
            ->first();

        // Get the college ID from the user's course
        $collegeId = $userCourse ? $userCourse->college_id : null;

        $courseSubquery = DB::table('courses')
            ->select('id')
            ->where('college_id', $collegeId);
        // Query for elections where the user can vote
        $elections = Election::select(
            'elections.id',
            'elections.title',
            'elections.scope',
        )
            ->where('elections.college_limit', $collegeId)
            ->orWhereIn('elections.course_limit', $courseSubquery)
            ->get();
        return view("voterdashboard", [
            "elections" => $elections
        ]);
    }
}
