<?php

namespace App\Http\Controllers;

use App\Models\College;
use Error;
use Flasher\Prime\Notification\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    public function show()
    {

        $colleges = DB::table("colleges")
            ->select(DB::raw("colleges.id, colleges.college_name, COUNT(users.id) AS count"))
            ->leftJoin("courses", "colleges.id", "=", "courses.college_id")
            ->leftJoin("users", function ($join) {
                $join->on("users.course_id", "=", "courses.id")
                    ->where("users.user_type", "=", 3); // Filtering users with user_type = 3
            })
            ->groupBy("colleges.id", "colleges.college_name")
            ->get();

        return view("colleges", [
            "colleges" => $colleges
        ]);
    }

    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                "college" => 'required|min:1|max:100',
            ]);

            if ($valid->fails()) {
                $er = $valid->errors()->get("college");
                toastr($er[0], Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }

            $new_college = College::create(
                [
                    "college_name" => $request->college
                ]
            );

            toastr("College Added Successfully!", Type::SUCCESS);
            return redirect()->route("college.index");
        } catch (QueryException $e) {
            toastr($e->errorInfo[2], Type::ERROR);
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {

        $id = $request->college_del;
        $college_data = College::find($id);

        if ($college_data != null) {
            $name = $college_data->college_name;

            $college_data->delete();

            toastr(`$name has been deleted successfully!`, Type::SUCCESS);
        } else {
            toastr("Course not found!", Type::ERROR);
        }

        return redirect()->route("college.index");
    }
}
