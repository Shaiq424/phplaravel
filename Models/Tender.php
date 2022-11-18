<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $table = 'tenders';
    protected $fillable = [
        'id',
        'tender_number',
        'tender_name',
        'date',
        'file',
    ];
}
