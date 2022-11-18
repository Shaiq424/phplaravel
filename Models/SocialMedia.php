<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table = 'social_media';
    protected $fillable = [
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
        'status',
        'created_at',
        'updated_at',
    ];

}
