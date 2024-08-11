<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        "fullname",
        "photo",
        "bio",
        "user_id",
        "position_id",
        "election_id",
        "votes"
    ];
}
