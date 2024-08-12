<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function show($id, Request $request)
    {
        $new_data = [];
        $highest = [];

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

        $c = null;
        foreach ($candidates as $cand) {
            if ($cand->position_name !== $c) {
                $new_data[$cand->position_name] = [];
                $max_vote[$cand->position_name] = $cand->max_vote;
                $c = $cand->position_name;

                try {
                    if ($highest[$c]['votes'] < $cand->votes) {
                        $highest[$c] = [
                            "votes" => $cand->votes,
                            "name" => $cand->fullname
                        ];
                    }
                } catch (\Throwable $th) {
                    $highest[$c] = [
                        "votes" => $cand->votes,
                        "name" => $cand->fullname
                    ];
                }
            }

            $new_data[$c][] = [
                "c_name" => $cand->fullname,
                "c_id" => $cand->id,
                "c_votes" => $cand->votes,
            ];
        }   
       
        
        return view("votes", [
            "new_data" => $new_data,
            "highest" => $highest
        ]);
    }
}
