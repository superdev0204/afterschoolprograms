<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'program_type',
        'page_url',
        'question',
        'user_id',
        'question_by',
        'question_email',
        'approved',
    ];
}
