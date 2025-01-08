<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'commentable_id',
        'email',
        'review_date',
        'review_by',
        'rating',
        'comments',
        'ip_address',
        'owner_comment',
        'helpful',
        'nohelp',
        'approved',
        'email_verified',
        'commentable_type',
        'user_id'
    ];
}
