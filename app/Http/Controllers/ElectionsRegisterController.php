<?php

namespace App\Http\Controllers;

use App\Jobs\ElectionRegister;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionData;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class ElectionsRegisterController extends Controller
{

    public function register(Request $request)
    {

        if (!$request->has('election_id')) {
            return response()->json([
                "message" => "Invalid Election"
            ], 403);
        }

        $election_data = Election::find($request->election_id);

        if ($election_data == null) {
            return response()->json([
                "message" => "Invalid Election"
            ], 403);
        }
        try {
            $batches = Bus::batch([])->dispatch();

            if ($election_data->scope == 1) {
                DB::table("users")->where("user_type", "!=", 1)->orderBy('id')->chunk(100, function ($user) use ($batches, $request) {
                    $batches->add(new ElectionRegister($user, $request->election_id));
                });
            } elseif ($election_data->scope == 2) {
                DB::table('users')->where('user_type', '!=', 1)->orderBy('id')
                    ->whereIn('course_id', function ($query) use ($election_data) {
                        $query->select('id')
                            ->from('courses')
                            ->where('college_id', $election_data->college_limit);
                    })
                    ->chunk(
                        100,
                        function ($user) use ($batches, $request) {
                            $batches->add(new ElectionRegister($user, $request->election_id));
                        }
                    );
            } else {
                DB::table('users')->where('user_type', '!=', 1)->orderBy("id")
                    ->where("year", "=", $election_data->year_level_limit)
                    ->where("course_id", "=", $election_data->course_limit)
                    ->chunk(100, function ($user) use ($batches, $request) {
                        $batches->add(new ElectionRegister($user, $request->election_id));
                    });
            }

            return response()->json([
                "message" => "Registering Voters...",
                "id" => $batches->id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th,
            ], 403);
        }
    }

    public function progress(Request $request)
    {
        $batch_id = $request->batch_id;
        return Bus::findBatch($batch_id);
    }

    public function destroy_voter($id, Request $request)
    {


        if ($request->has('vtr_id')) {
            $voter_data = ElectionData::find($request->vtr_id);

            if ($voter_data === null) {
                $data = ["message" => "Voter Don't Exist!"];
                $code = 404;
            } else {
                $voter_data->delete();

                $is_candidate = Candidate::where(
                    [
                        ['user_id', "=", $voter_data->voter_id],
                        ['election_id', "=", $voter_data->election_id]
                    ]
                );

                if ($is_candidate) {
                    $is_candidate->delete();
                }

                $data = [
                    "message" => "Voter Removed From Election!",
                    "name" => $voter_data->voter_name
                ];
                $code = 200;
            }
        } else {
            $data = ["message" => "Undefined Voter!"];
            $code = 404;
        }
        return response()->json($data, $code);
    }

    public function store_voter($id, Request $request)
    {
        if ($request->has("add_user_id") && $request->has("elec_id")) {
            $elec_id = $request->elec_id;
            $voter = User::find($request->add_user_id);

            if ($elec_id === $id && $voter !== null) {
                $has_data = ElectionData::where(
                    [
                        ["voter_id", "=", $voter->id],
                        ["election_id", "=", $elec_id]
                    ]
                )->exists();
                    
                
                if ($has_data) {
                    return response()->json([
                        "message" => "Voter Already Exist!",
                    ], 403);
                }

                ElectionData::create([
                    "voter_name" => $voter->first_name . " " . $voter->last_name,
                    "voter_id" => $voter->id,
                    "election_id" => $elec_id
                ]);

                $data = ElectionData::where(
                    [
                        ["voter_name", "=", $voter->first_name . " " . $voter->last_name],
                        ["election_id", "=", $elec_id]
                    ]
                )->first();

            
                return response()->json([
                    "message" => "Voter Added!",
                    "voter_name" => $voter->first_name . " " . $voter->last_name,
                    "id" => $data->id
                ], 200);
            } else {
                return response()->json([
                    "message" => "Action Forbidden!"
                ], 403);
            }
        } else {
            return response()->json([
                "message" => "Expected id but passed null!"
            ], 403);
        }
    }
}
