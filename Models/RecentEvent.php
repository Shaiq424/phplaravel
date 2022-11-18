<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentEvent extends Model
{
    use HasFactory;
    protected $table = 'event_gallery';
    protected $fillable = [
        'event_id',
        'image',
        'created_at',
        'updated_at',
    ];
    
}
