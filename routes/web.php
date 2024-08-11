<?php

use App\Http\Controllers\BallotController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ElectionsController;
use App\Http\Controllers\ElectionsRegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use App\Jobs\ElectionRegister;
use App\Models\College;
use Illuminate\Support\Facades\Route;


/* 
    TODO: Add Gate Rules after full implementation
    //TODO: Group the route
    TODO: ->middleware('can:Gatename'); For Auth
*/

Route::get('/', [IndexController::class, "index"])->name("index")
    ->middleware('auth');

Route::get('/vote', [VoteController::class, "votes"])->name("votes")
    ->middleware('auth');


Route::group(['prefix' => 'college/', 'as' => "college.", "middleware" => ['auth']], function () {
    Route::get("", [CollegeController::class, "show"])->name("index");

    Route::post("/create", [CollegeController::class, "store"])->name("store");

    Route::delete("/delete", [CollegeController::class, "destroy"])->name("destroy");
});


Route::group(['prefix' => 'courses/', 'as' => "courses.", "middleware" => ['auth']], function () {
    Route::get("", [CoursesController::class, "index"])->name("index");

    Route::post("/create", [CoursesController::class, "store"])->name('store');

    Route::delete("/destroy", [CoursesController::class, "destroy"])->name('destroy');
});

Route::group(['prefix' => 'voters/', 'as' => "voters.", "middleware" => ['auth']], function () {
    Route::get("", [VoterController::class, "index"])->name("index");

    Route::post('/sign-up', [VoterController::class, "store"])->name('store');

    Route::put('/update', [VoterController::class, "update"])->name('update');

    Route::delete('/delete', [VoterController::class, "destroy"])->name('destroy');

    Route::get('/user/data', [VoterController::class, "api"])->name('api');

    Route::post("/upload", [VoterController::class, "upload"])->name("upload");

    Route::post("/register", [VoterController::class, "registerVoters"])->name("register");

    Route::get("/upload/progress", [VoterController::class, "progress"])->name('progress');

    Route::delete("/voter/delete/election/id/{id}", [ElectionsRegisterController::class, "destroy_voter"])->name("delete_specific");

    Route::get("/voter/find", [VoterController::class, "find"])->name("find");
});

Route::group(['prefix' => 'positions/', 'as' => "positions.", "middleware" => ['auth']], function () {
    Route::get('', [PositionsController::class, "index"])->name('index');

    Route::post('/positions/create', [PositionsController::class, "store"])->name('store');

    Route::put("/update", [PositionsController::class, "update"])->name("update");

    Route::delete("/delete", [PositionsController::class, "destroy"])->name("destroy");

    Route::get("/positions/data", [PositionsController::class, "api"])->name("api");
});

Route::group(['prefix' => 'elections/', 'as' => "elections.", "middleware" => ['auth']], function () {
    Route::get("", [ElectionsController::class, "index"])->name('index');

    Route::get('/information/id/{id}', [ElectionsController::class, "show"])->name("show");

    Route::get('/voter/data', [ElectionsController::class, "find"])->name("search");

    Route::get('/{action}/id/{id}', [ElectionsController::class, "update"])->name("update");

    Route::delete('/delete', [ElectionsController::class, "destroy"])->name("destroy");

    Route::post("/create", [ElectionsController::class, "store"])->name('store');

    Route::post('/register/voter', [ElectionsRegisterController::class, "register"])->name('register');

    Route::get('/progress', [ElectionsRegisterController::class, "progress"])->name("progress");

    Route::post("/add/voter/id/{id}", [ElectionsRegisterController::class, "store_voter"])->name("store_voter");

});

Route::group(['prefix' => 'candidate/', 'as' => 'candidate.', 'middleware' => ['auth']], function () {

    Route::post('/add/election/{id}', [CandidateController::class, "store"])->name("store");

    Route::delete('/delete/election/id/{id}', [CandidateController::class, "destroy"])->name("destroy");
});

Route::group(['prefix' => 'ballot/', 'as' => 'ballot.', 'middleware' => ['auth']], function () {
    Route::get("/election/id/{id}", [BallotController::class, "show"])->name("show");

    Route::get('/cast/vote/{id}/user/{u_id}', [BallotController::class, "store"])->name("cast");
});


require __DIR__ . '/auth.php';
