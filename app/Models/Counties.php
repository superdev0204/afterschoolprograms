<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counties extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'county',
        'state',
        'countyfile',
        'center_count',
        'homebase_count',
        'statefile',
        'referalResources',
        'headstart_count',
    ];
}
