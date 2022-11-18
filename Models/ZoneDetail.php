<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneDetail extends Model
{
    use HasFactory;

    protected $table = 'zonedetail';
    protected $fillable = [
        'is_zone',
        'uc_number',
        'uc_name',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];
}
