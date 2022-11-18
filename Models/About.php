<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about';
    protected $fillable = [
        'title',
        'image',
        'description',
        'heading',
        'line_1',
        'circle_1_title',
        'circle_1_count',
        'circle_2_title',
        'circle_2_count',
        'circle_3_title',
        'circle_3_count',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
