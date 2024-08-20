<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function show($id, Request $request)
    {
        $new_data = [];

        $candidates = DB::table("candidates")
            ->select(DB::raw("
                candidates.id,
                candidates.bio,
                candidates.photo,
                candidates.fullname,
                candidates.votes,
                positions.name as position_name,
                positions.max_vote as max_vote,
                positions.priority as prio
            "))
            ->join("positions", "candidates.position_id", "=", "positions.id")
            ->where("candidates.election_id", "=", $id)
            ->orderBy("prio")
            ->orderBy("fullname")
            ->get();

        $positions = DB::table("candidates")
            ->select(DB::raw("DISTINCT(position_id),
            positions.name,
            positions.max_vote"))
            ->join("positions", "position_id", "=", "positions.id")
            ->where("election_id", "=", $id)
            ->get();

        $positionWinners = [];

        foreach ($positions as $p) {
            $winners = DB::table("candidates")
                ->where(
                    [
                        ["position_id", "=", $p->position_id],
                        ["election_id", "=", $id]
                    ]
                )->orderBy("votes")
                ->limit($p->max_vote)->get();

            foreach ($winners as $w) {
                $positionWinners[$p->name][] = [
                    "name" => $w->fullname,
                    "votes" => $w->votes
                ];
            }
        }

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
                "c_votes" => $cand->votes,
            ];
        }


        return view("votes", [
            "new_data" => $new_data,
            "winners" => $positionWinners,
            "id" => $id
        ]);
    }

    public function api($id, Request $request)
    {
        $new_data = [];

        $candidates = DB::table("candidates")
            ->select(DB::raw("
                candidates.id,
                candidates.bio,
                candidates.photo,
                candidates.fullname,
                candidates.votes,
                positions.name as position_name,
                positions.max_vote as max_vote,
                positions.priority as prio
            "))
            ->join("positions", "candidates.position_id", "=", "positions.id")
            ->where("candidates.election_id", "=", $id)
            ->orderBy("prio")
            ->orderBy("fullname")
            ->get();

        $positions = DB::table("candidates")
            ->select(DB::raw("DISTINCT(position_id),
            positions.name,
            positions.max_vote"))
            ->join("positions", "position_id", "=", "positions.id")
            ->where("election_id", "=", $id)
            ->get();

        $positionWinners = [];

        foreach ($positions as $p) {
            $winners = DB::table("candidates")
                ->where(
                    [
                        ["position_id", "=", $p->position_id],
                        ["election_id", "=", $id]
                    ]
                )->orderBy("votes")
                ->limit($p->max_vote)->get();

            foreach ($winners as $w) {
                $positionWinners[$p->name][] = [
                    "name" => $w->fullname,
                    "votes" => $w->votes
                ];
            }
        }

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
                "c_votes" => $cand->votes,
            ];
        }

        return response()->json([
            "new_data" => $new_data,
            "winners" => $positionWinners
        ], 200);
    }
}
