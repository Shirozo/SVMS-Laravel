<?php

use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use App\Models\College;
use Illuminate\Support\Facades\Route;


// TODO: Add Gate Rules after full implementation

Route::get('/', [IndexController::class, "index"])->name("index")
    ->middleware('auth');

Route::get('/vote', [VoteController::class, "votes"])->name("votes")
    ->middleware('auth');



Route::get("/college", [CollegeController::class, "show"])->name("college.index")
    ->middleware('auth');
// ->middleware('can:Gatename'); For Auth
Route::post("/college/create", [CollegeController::class, "store"])
    ->middleware('auth')
    ->name("college.store");

Route::delete("college/delete/", [CollegeController::class, "destroy"])
    ->middleware("auth")
    ->name("college.destroy");



Route::get("/courses/create", [CoursesController::class, "index"])
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
Route::delete('/voter/delete', [VoterController::class, "destroy"])
    ->middleware('auth')
    ->name('voters.destroy');
Route::put('/voters/update', [VoterController::class, "update"])
    ->middleware('auth')
    ->name('voters.update');
Route::get('/voter/user/data/', [VoterController::class, "api"])
    ->middleware('auth')
    ->name('voter.api');


Route::get('/positions', [PositionsController::class, "index"])
    ->middleware('auth')
    ->name('positions.index');
Route::post('/positions/create', [PositionsController::class, "store"])
    ->middleware('auth')
    ->name('positions.store');
Route::delete("/positions/delete", [PositionsController::class, "destroy"])
    ->middleware("auth")
    ->name("positions.destroy");
Route::get("/positions/data", [PositionsController::class, "api"])
    ->middleware("auth")
    ->name("positions.api");
Route::put("/positions/update", [PositionsController::class, "update"])
    ->middleware("auth")
    ->name("positions.update");

require __DIR__ . '/auth.php';
