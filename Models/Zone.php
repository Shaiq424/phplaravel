<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';
    protected $fillable = [
        'zone_head',
        'lang_id',
        'created_at',
        'updated_at',
    ];


    public function getZoneInfo()
    {
        return $this->hasMany(ZoneDetail::class,'is_zone','id');
    }
}
