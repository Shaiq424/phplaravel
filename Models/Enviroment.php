<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enviroment extends Model
{
    use HasFactory;

    protected $table = 'enviroments';
    protected $fillable = [
        'id',
        'description',
        'file',
    ];
}
