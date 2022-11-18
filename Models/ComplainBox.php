<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplainBox extends Model
{
    use HasFactory;

    protected $table = 'complain_box';
    protected $fillable = [
        'title',
        'description',
        'btn_title',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
