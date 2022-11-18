<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latest extends Model
{
    use HasFactory;

    protected $table = 'latest';
    protected $fillable = [
        'id',
        'file'
    ];
}
