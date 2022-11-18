<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'description',
        'btn_title',
        'btn_link',
        'date',
        'featured_img',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
