<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function college() {
        return view("colleges");
    }
}
