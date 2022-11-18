<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $table = 'footer';
    protected $fillable = [
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
        'copy_right',
        'complain',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
