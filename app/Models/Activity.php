<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activity';
    public $timestamps = false;

    protected $fillable = [
        'ext_id',
        'name',
        'address',
        'city',
        'state',
        'zip',
        'category',
        'lat',
        'lng',
        'note',
        'phone',
        'url',
        'filename',
        'email',
        'details',
        'kids_program_url',
        'summer_program_url',
        'photo_url1',
        'photo_url2',
        'photo_url3',
        'photo_url4',
        'video_url',
        'approved',
        'sub_category',
        'gender',
        'type',
        'season',
        'state_association',
        'region',
        'motto',
        'contact_name',
        'user_id',
        'claim',
        'created',
        'updated',
    ];
}
