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

    public function index()
    {
        $positions = Position::all();
        return view('position', [
            "positions" => $positions
        ]);
    }

    public function store(Request $request)
    {

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

    public function api(Request $request)
    {
        $id = $request->p_id;
        $data = Position::find($id);

        if ($data != null) {
            return response()->json([
                "data" => $data
            ], 200);
        }

        return response()->json([
            "message" => "Unkown Voter!",
        ], 404);
    }

    public function update(Request $request)
    {

        $valid = Validator::make($request->all(), [
            "up_p_id" => "required",
            "name" => 'required|max:50|min:1',
            "max_vote" => 'required|min_digits:1',
            'exclusive' => 'required|in:0,1'
        ]);

        if ($valid->fails()) {
            toastr("Form Validation Error", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }

        $p_id = $request->up_p_id;

        $past_data = Position::find($p_id);

        if ($past_data != null) {
            $past_data->update([
                "name" => $request->name,
                "max_vote" => $request->max_vote,
                "exclusive" => $request->exclusive
            ]);

            toastr("Position Updated!", Type::SUCCESS);
            return redirect()->route("positions.index");
        }
        else {
            toastr("Position Doesn't Exist", Type::ERROR);
            return redirect()->back()->withErrors($valid);
        }
    }

    public function destroy(Request $request)
    {

        $id = $request->p_id_del;

        $data = Position::find($id);

        if ($data != null) {
            $data->delete();
            toastr("Position Deleted!", Type::SUCCESS);
        } else {
            toastr("Position Desn't exist!", Type::ERROR);
        }

        return redirect()->route('positions.index');
    }
}
