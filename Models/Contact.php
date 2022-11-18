<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';
    protected $fillable = [
        'iframe_link',
        'placeholder_name',
        'placeholder_fullname',
        'placeholder_email',
        'placeholder_message',
        'btn_title',
        'lang_id',
        'created_at',
        'updated_at',
    ];
}
