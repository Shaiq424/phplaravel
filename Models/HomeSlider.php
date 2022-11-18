<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;
    protected $table = 'home_slider';
    protected $fillable = [
        'title',
        'line_1',
        'description',
        'image',
        'btn_title',
        'btn_link',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
