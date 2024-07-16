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
                
                $data = ["message" => "Voter Removed From Election!"];
                $code = 200;

            }
        } else {
            $data = ["message" => "Undefined Voter!"];
            $code = 404;
        }
        return response()->json($data, $code);
    }
}
