<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Error;
use Flasher\Prime\Notification\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function store(Request $request) {

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
            }
            else {
                toastr("Invalid Course Field!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }


            dump($valid->fails());
        } catch (QueryException $er) {
            toastr($er->errorInfo[2], Type::ERROR);
            return redirect()->back();
        }
    }

    public function destroy(Request $request) {
        $user_id = $request->user_del;
        $user_data = User::find($user_id);

        if ($user_data != null) {

            $user_data->delete();
            toastr("User has been deleted!", Type::SUCCESS);
        }
        else {
            toastr("User is not registered!", Type::ERROR);
        }

        return redirect()->route("voters.index");
    }


}
