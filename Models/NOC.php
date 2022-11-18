<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NOC extends Model
{
    use HasFactory;

    protected $table = 'n_o_c_s';
    protected $fillable = [
        'id',
        'description',
        'file'
    ];
}
