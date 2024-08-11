<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionData;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BallotController extends Controller
{

    public function show($id, Request $request)
    {

        $new_data = [];
        $max_vote = [];

        $election = Election::find($id);

        $candidates = DB::table("candidates")
            ->select(DB::raw("
                candidates.id,
                candidates.bio,
                candidates.photo,
                candidates.fullname,
                positions.name as position_name,
                positions.max_vote as max_vote
            "))
            ->join("positions", "candidates.position_id", "=", "positions.id")
            ->where("candidates.election_id", "=", $id)
            ->get();

        $c = null;
        foreach ($candidates as $cand) {
            if ($cand->position_name !== $c) {
                $new_data[$cand->position_name] = [];
                $max_vote[$cand->position_name] = $cand->max_vote;
                $c = $cand->position_name;
            }
            $new_data[$c][] = [
                "c_name" => $cand->fullname,
                "c_id" => $cand->id,
                "c_bio" => $cand->bio,
                "c_photo" => $cand->photo
            ];
        }


        return view('ballot', [
            "candidates" => $new_data,
            "max_vote" => $max_vote,
            "election" => $election
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
                ->first();

            foreach ($positions as $p) {
                $key = str_replace(" ", "_", (string) $p->name);
                $data = $request->$key;
                if ($p->max_vote === 1) {
                    $candidate_data = Candidate::find($request->$key);
                    if ($candidate_data->election_id != $id) {
                        DB::rollBack();
                        toastr("Form Validation Failed!", Type::ERROR);
                        return redirect()->back();
                    }

                    $candidate_data->update([
                        "votes" => $candidate_data->votes + 1
                    ]);
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
                    }
                }
            }

            DB::commit();
            
            
            $user_data->update([
                "has_voted" => true
            ]);
            
            toastr("Vote Casted!", Type::SUCCESS);
            return redirect()->route('some.route');


        } catch (\Throwable $th) {
            DB::rollBack();
            toastr("An error occurred. Please try again.", Type::ERROR);
            return redirect()->back();
        }
    }
}
