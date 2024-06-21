<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use App\Models\College;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, "index"])->name("index")
    ->middleware('auth');

Route::get('/vote', [VoteController::class, "votes"])->name("votes")
    ->middleware('auth');

Route::get("/college", [CollegeController::class, "show"])->name("college.index")
    ->middleware('auth');
// ->middleware('can:Gatename'); For Auth
Route::post("/college", [CollegeController::class, "store"])
    ->middleware('auth')
    ->name("college.store");

Route::delete("college/delete/{id}", [CollegeController::class, "destroy"])
    ->middleware("auth")
    ->name("college.destroy");

Route::get("/voters", [VoterController::class, "voters"])->name("voters")
    ->middleware('auth');

require __DIR__ . '/auth.php';
