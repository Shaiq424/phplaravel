<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDirectorys extends Model
{
    use HasFactory;

    protected $table = 'staff_directories';
    protected $fillable = [
        'id',
        'name',
        'designation',
        'ext',
        'contact',
    ];
}
