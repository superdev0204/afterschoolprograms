<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'state_code',
        'state_name',
        'statefile',
        'latitude',
        'longitude',
        'country',
        'coords',
        'nextlevel',
        'agency',
        'introduction',
    ];
}
