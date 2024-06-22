<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Error;
use Flasher\Prime\Notification\Type;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class VoterController extends Controller
{
    public function index()
    {

        // TODO: Change voters to custom query
        $voters = User::all();
        $courses = Course::all();

        return view("voters", [
            "voters" => $voters,
            "courses" => $courses
        ]);
    }

    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                "first_name" => 'required|max:30|min:1',
                "middle_name" => 'required|max:30|min:1',
                "last_name" => 'required|max:30|min:1',
                "email" => 'required|email',
                "username" => 'required|max:30|min:1',
                "password" => 'required|max:16|min:8',
                "student_id" => 'required|max:8|min:8',
                "course" => 'required|numeric',
                "year" => 'required|numeric|max:4|min:1'

            ]);

            if ($valid->fails()) {
                toastr("Form Validation Error!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }

            if (Course::where("id", $request->course)->exists()) {

                $new_user = User::create([
                    "first_name" => $request->first_name,
                    "middle_name" => $request->middle_name,
                    "last_name" => $request->last_name,
                    "email" => $request->email,
                    "username" => $request->username,
                    "password" => Hash::make($request->password),
                    "student_id" => $request->student_id,
                    "user_type" => 3,
                    "course_id" => $request->course,
                    "year" => $request->year
                ]);

                toastr("New Voter Added!", Type::SUCCESS);
                return redirect()->route("voters.index");
            } else {
                toastr("Invalid Course Field!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }


            dump($valid->fails());
        } catch (QueryException $er) {
            toastr($er->errorInfo[2], Type::ERROR);
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {

        $valid = Validator::make($request->all(), [
            "update_id" => 'required',
            "edit_first_name" => 'required|max:30|min:1',
            "edit_middle_name" => 'required|max:30|min:1',
            "edit_last_name" => 'required|max:30|min:1',
            "edit_email" => 'required|email',
            "edit_username" => 'required|max:30|min:1',
            "edit_course" => 'required|numeric',
            "edit_year" => 'required|numeric|max:4|min:1',
        ]);

        if ($valid->fails()) {
            toastr("Form validation error!", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }

        $user_data = User::find($request->update_id);

        if ($user_data == null) {
            toastr("Can't find voter data!", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }

        if ($request->edit_password != null) {
            if (strlen($request->edit_password) >= 8 && strlen($request->edit_password) <= 16) {
                $password = Hash::make($request->edit_password);
            }
            else {
                toastr("Password should consist of 8-16 character!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        }
        else {
            $password = $user_data->password;
        }

        $status = array(
            "on" => 1,
            "" => 0
        );



        $user_data->update([
            "first_name" => $request->edit_first_name,
            "middle_name" => $request->edit_middle_name,
            "last_name" => $request->edit_last_name,
            "email" => $request->edit_email,
            "username" => $request->edit_username,
            "password" => $password,
            "course_id" => $request->edit_course,
            "year" => $request->edit_year,
            "status" => $status[$request->edit_status],
            'remember_token' => Str::random(60)
        ]);

        event(new PasswordReset($user_data));

        toastr("Voter Updated!", Type::SUCCESS);
        return redirect()->route('voters.index');

    }

    public function api(Request $request) {
        $id = $request->voter_id;
        $data = User::find($id);

        if ($data != null) {
            return response()->json([
                "data" => $data
            ], 200);
        }

        return response()->json([
            "message" => "Unkown Voter!",
        ], 404);
    }

    public function destroy(Request $request)
    {
        $user_id = $request->user_del;
        $user_data = User::find($user_id);

        if ($user_data != null) {

            $user_data->delete();
            toastr("User has been deleted!", Type::SUCCESS);
        } else {
            toastr("User is not registered!", Type::ERROR);
        }

        return redirect()->route("voters.index");
    }
}
