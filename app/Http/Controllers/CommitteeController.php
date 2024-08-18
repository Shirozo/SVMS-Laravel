<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function show(Request $request) {
        return view("committee");
    }
}
