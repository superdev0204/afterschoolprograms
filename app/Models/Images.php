<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'imagename',
        'altname',
        'approved',
        'created',
        'updated',
        'user_id'
    ];
}
