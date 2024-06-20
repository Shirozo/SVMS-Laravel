<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, "index"])->name("index");

Route::get('/vote', [VoteController::class, "votes"])->name("votes");

Route::get("/college", [CollegeController::class, "college"])->name("college");

Route::get("/voters", [VoterController::class, "voters"])->name("voters");

require __DIR__ . '/auth.php';
