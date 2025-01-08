<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'city',
        'county',
        'state',
        'latitude',
        'longitude',
        'filename',
        'statefile',
        'countyfile',
        'headstart_count',
    ];
}
