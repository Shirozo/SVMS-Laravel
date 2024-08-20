<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Committee;
use App\Models\User;
use Flasher\Prime\Notification\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommitteeController extends Controller
{
    public function show(Request $request)
    {
        $colleges = College::all();

        $committee = DB::table("users")
        ->select(DB::raw("concat(users.first_name, ' ', users.last_name) as fullname,
            users.ssc,
            users.id,
            users.username,
            colleges.college_name"))
        ->leftJoin("colleges", "users.scope", "=", "colleges.id")
        ->where("users.user_type", "=", "2")
        ->get();

        return view("committee", [
            "colleges" => $colleges,
            "committee" => $committee
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $valid = Validator::make($request->all(), [
                "user_id" => 'required|numeric',
                "username" => 'required|max:30|min:1',
                "password" => 'required|max:16|min:8',
                "ssc" => 'required|in:0,1',
            ]);

            if ($valid->fails()) {
                toastr("Invalid Form!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }

            $data = User::find($request->user_id);

            if ($data != null) {
                $user = User::create([
                    "first_name" => $data->first_name,
                    "last_name" => $data->last_name,
                    "middle_name" => $data->middle_name,
                    "username" => $request->username,
                    "password" => $request->password,
                    "user_type" => 2,
                    "ssc" => $request->ssc,
                    "course_id" => $data->course_id,
                    "year" => $data->course_year,
                    "scope" => $request->scope
                ]);

                DB::commit();

                toastr("Committee Added!", Type::SUCCESS);
                return redirect()->route("committee.show");
            }
            else {
                DB::rollBack();
                toastr("Can't Find That User!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr("Server Error!", Type::ERROR);
            return redirect()->back();
        }
    }

    public function destroy(Request $request) {
        if ($request->has("id")) {
            try {   
                $data = User::find($request->id);

                $data->delete();
                toastr("Deleted Committee!", Type::SUCCESS);
                return redirect()->route("committee.show");
            }   
            catch (\Throwable $th){
                toastr("Server Error!", Type::ERROR);
                // return redirect()->route("committee.show");
                dump($th);
            }
        }
    }
}
