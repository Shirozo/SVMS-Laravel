<?php

namespace App\Http\Controllers;

use App\Models\College;
use Flasher\Prime\Notification\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    public function show()
    {

        $colleges = College::all();

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
                return redirect()->back();
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
}
