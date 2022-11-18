<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laws extends Model
{
    use HasFactory;
    protected $table = 'laws';
    protected $fillable = [
        'description',
        'category',
        'download_pdf',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
