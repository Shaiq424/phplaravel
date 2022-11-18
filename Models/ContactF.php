<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactF extends Model
{
    use HasFactory;

    protected $table = 'contact_f';
    protected $fillable = [
        'id',
        'name',
        'first_name',
        'phone_number',
        'email',
        'message'
    ];
}
