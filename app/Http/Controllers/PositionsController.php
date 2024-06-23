<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Flasher\Prime\Notification\Type;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PositionsController extends Controller
{

    public function index() {
        $positions = Position::all();
        return view('position', [
            "positions" => $positions
        ]);
    }

    public function store(Request $request) {

        try {
            $valid = Validator::make($request->all(), [
                "name" => 'required|max:50|min:1',
                "max_vote" => 'required|min_digits:1',
                'exclusive' => 'required|in:0,1'
            ]);

            if ($valid->fails()) {
                toastr("Form Validation Error!", Type::ERROR);
                return redirect()->back()->withErrors($valid);
            }

            $priority = DB::table('positions')->count() + 1;

            $new_position = Position::create([
                "name" => $request->name,
                "max_vote" => $request->max_vote,
                "priority" => $priority,
                "exclusive" => $request->exclusive
            ]);

            toastr("New Position Added", Type::SUCCESS);
            return redirect()->route("positions.index");

        } catch (QueryException $er) {
            toastr($er->errorInfo[2], Type::ERROR);
            return redirect()->back();
        }
    }
}
