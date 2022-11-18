<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialManagementFramework extends Model
{
    use HasFactory;

    protected $table = 'smframework';
    protected $fillable = [
        'title',
        'image',
        'download_pdf',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
