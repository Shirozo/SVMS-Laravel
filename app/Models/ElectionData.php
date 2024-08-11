<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class ElectionData extends Model
{
    use HasFactory, Eloquence;

    protected $searchableColumns = ['voter_name'];

    protected $fillable = [
        "voter_name",
        "voter_id",
        "election_id",
        "has_voted"
    ];
}
