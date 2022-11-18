<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UC extends Model
{
    use HasFactory;

    protected $table = 'u_c_s';
    protected $fillable = [
        'id',
        'zone',
        'uc_number',
        'uc_name'
    ];

}
