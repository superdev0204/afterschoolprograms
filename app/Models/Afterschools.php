<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afterschools extends Model
{
    use HasFactory;

    protected $table = 'afterschool';
    public $timestamps = false;

    protected $fillable = [
        'state_id',
        'name',
        'location',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'phone',
        'phone_ext',
        'operation_id',
        'county',
        'email',
        'created',
        'capacity',
        'status',
        'type',
        'contact_firstname',
        'contact_lastname',
        'age_range',
        'transportation',
        'lat',
        'lng',
        'filename',
        'visits',
        'updated',
        'state_rating',
        'website',
        'subsidized',
        'accreditation',
        'cityfile',
        'approved',
        'daysopen',
        'hoursopen',
        'typeofcare',
        'language',
        'introduction',
        'additionalInfo',
        'pricing',
        'user_id',
        'is_activities',
        'is_afterschool',
        'is_camp',
        'gmap_heading',
        'logo',
        'schools_served',
        'category',
        'claim',
    ];
}
