<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementPlan extends Model
{
    use HasFactory;

    protected $table = 'procurement_plan';
    protected $fillable = [
        'id',
        'description',
        'file'
    ];
}
