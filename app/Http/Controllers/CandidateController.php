<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionData;
use App\Models\Position;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function store($id, Request $request)
    {

        $valid_data = Validator::make($request->all(), [
            "user_id" => "required|numeric",
            "bio" => "required",
            "position" => "required|numeric",
            "photo" => "required|image"
        ]);

        if ($valid_data->fails()) {
            toastr("Invalid Form!", Type::ERROR);
            return redirect()->back()->withErrors($valid_data);
        }

        $user = ElectionData::where(
            [
                ['voter_id', '=', $request->user_id],
                ['election_id', '=', $id]
            ]
        )->first();

        $election = Election::find($id);

        if ($user && $election !== null) {

            $folder = "candidates/" . $election->title . '-' . $election->id;

            $fullPath = resource_path($folder);

            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0775, true);
            }

            $position = Position::select('name')->find($request->position);

            $ext = $request->file('photo')->extension();

            $filename = $position->name . $request->user_id . '.' . $ext;

            $request->file("photo")->move($fullPath, $filename);

            Candidate::create([
                "fullname" => $user->voter_name,
                "photo" => $filename,
                "bio" => $request->bio,
                "user_id" => $request->user_id,
                "position_id" => $request->position,
                "election_id" => $election->id
            ]);

            toastr("Candidate Added!", Type::SUCCESS);
            return redirect()->route("elections.show", ['id' => $id]);
        }

        toastr("Invalid Form!", Type::ERROR);
        return redirect()->back()->withErrors($valid_data);
    }

    public function destroy($id, Request $request)
    {
        if ($request->has("del_id")) {
            $c_id = $request->del_id;
            $data = Candidate::find($c_id);

            if ($data === null) {
                toastr("Invalid Candidate!", Type::ERROR);
            } else {
                $data->delete();
                toastr("Candidate Deleted!", Type::SUCCESS);
            }
        } else {
            toastr("Candidate Required!", Type::ERROR);
        }

        return redirect()->route("elections.show", ["id" => $id]);

    }
}
