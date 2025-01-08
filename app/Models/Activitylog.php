<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activitylog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'ext_id',
        'name',
        'address',
        'city',
        'state',
        'zip',
        'category',
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
        'provider_status',
        'user_id',
        'claim',
        'created',
        'updated',
    ];

    public function activity(): BelongsTo{
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function getEditableFields()
    {
        return [
            'name' => 'Name',
            'address' => 'Address',
            'city' => 'City',
            'zip' => 'Postal',
            'state' => 'State',
            'category' => 'Category',
            'note' => 'Note',
            'phone' => 'Phone',
            'url' => 'Url',
            'email' => 'Email',
            'details' => 'Details',
            'kids_program_url' => 'Kids Program Url',
            'summer_program_url' => 'Summer Program Url',
            'video_url' => 'Video Url',
            'sub_category' => 'Sub Category',
            'gender' => 'Gender',
            'type' => 'Type',
            'season' => 'Season',
            'state_association' => 'State Association',
            'region' => 'Region',
            'motto' => 'Motto',
            'contact_name' => 'Contact Name',
            'claim' => 'Claim',
        ];
    }
}
