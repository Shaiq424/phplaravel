<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickLinks extends Model
{
    use HasFactory;
    
    protected $table = 'quick_links';
    protected $fillable = [
        'tag_title',
        'tag_links',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
