<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{
    use HasFactory;

    protected $table = 'functions';
    protected $fillable = [
        'description',
        'title_one',
        'title_two',
        'title_three',
        'title_four',
        'title_five',
        'title_six',
        'title_seven',
        'lang_id',
        'created_at',
        'updated_at',
    ];

}
