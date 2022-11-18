<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictMunciple extends Model
{
    use HasFactory;

    protected $table = 'district_munciple_video';
    protected $fillable = [
        'title',
        'district',
        'bg_image',
        'video',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
