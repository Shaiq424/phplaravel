<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    use HasFactory;

    protected $table = 'testimonials';
    protected $fillable = [
        'image',
        'name',
        'designation',
        'message',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
