<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'program_id',
        'program_type',
        'page_url',
        'answer',
        'user_id',
        'answer_by',
        'answer_email',
        'approved',
    ];
}
