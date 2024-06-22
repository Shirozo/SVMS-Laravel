<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use Flasher\Prime\Notification\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    public function index()
    {

        $courses = Course::all();
        $colleges = College::all();
        return view('courses', [
            "courses" => $courses,
            "colleges" => $colleges
        ]);
    }

    public function store(Request $request)
    {
        try {
            $valid = Validator::make($request->all(), [
                "course" => 'required|max:100|min:1',
                "college" => 'required|numeric'
            ]);

            if ($valid->fails()) {
                toastr("Form Invalid!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }

            if (College::where('id', $request->college)->exists()) {

                $new_course = Course::create([
                    "course_name" => $request->course,
                    "college_id" => $request->college
                ]);

                toastr("New Course Added!", Type::SUCCESS);
                return redirect()->route("courses.index");
            } else {
                toastr("Invalid College Selection", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }
        } catch (QueryException $er) {
            toastr($er->errorInfo[2], Type::ERROR);
            return redirect()->back();
        }
    }

    public function destroy(Request $request) {

        $course_id = $request->course_del;
        $course_data = Course::find($course_id);

        if ($course_data != null) {
            $course_data->delete();

            toastr("Course Deleted!", Type::SUCCESS);
        }
        else {
            toastr("Course not found!", Type::ERROR);
        }

        return redirect()->route('courses.index');

    }
}
