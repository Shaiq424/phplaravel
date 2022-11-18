<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMinute extends Model
{
    use HasFactory;

    protected $table = 'meeting_minutes';
    protected $fillable = [
        'id',
        'description',
        'file'
    ];
}
