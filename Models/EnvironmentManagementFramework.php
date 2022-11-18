<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentManagementFramework extends Model
{
    use HasFactory;
    protected $table = 'emframework';
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
