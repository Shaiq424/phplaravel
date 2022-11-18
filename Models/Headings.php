<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headings extends Model
{
    use HasFactory;
    protected $table = 'headings';
    protected $fillable = [
        'headings',
        'type_id',
        'lang_id',
        'lang_id',
        'created_at',
        'updated_at',
    ];
}
