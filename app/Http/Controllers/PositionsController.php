<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PositionsController extends Controller
{

    public function index() {
        return view('position');
    }
}
