<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplainForm extends Model
{
    use HasFactory;

    protected $table = 'complain_forms';
    protected $fillable = [
        'id',
        'name',
        'first_name',
        'phone_number',
        'email',
        'message'
    ];
}
