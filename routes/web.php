<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CoursesController;
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

Route::delete("college/delete/", [CollegeController::class, "destroy"])
    ->middleware("auth")
    ->name("college.destroy");



Route::get("/courses", [CoursesController::class, "index"])
    ->middleware("auth")
    ->name("courses.index");
Route::post("/courses", [CoursesController::class, "store"])
    ->middleware('auth')
    ->name('courses.store');
Route::delete("/course/destroy", [CoursesController::class, "destroy"])
    ->middleware('auth')
    ->name('courses.destroy');


Route::get("/voters", [VoterController::class, "index"])->name("voters.index")
    ->middleware('auth');
Route::post('/voters/sign-up', [VoterController::class, "store"])
    ->middleware('auth')
    ->name('voters.store');

require __DIR__ . '/auth.php';
