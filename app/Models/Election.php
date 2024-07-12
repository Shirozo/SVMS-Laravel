<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "scope",
        "college_limit",
        "course_limit",
        "year_level_limit",
        "started"
    ];
}
