<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_name',
        'from_email',
        'from_userid',
        'to_name',
        'to_email',
        'to_userid',
        'type',
        'subject',
        'message',
        'previous_id',
        'readdate',
        'responsedate',
        'ip_sent'
    ];
}
