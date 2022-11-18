<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'name',
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getImages()
    {
        return $this->hasMany(RecentEvent::class,'event_id','id');
    }
}
