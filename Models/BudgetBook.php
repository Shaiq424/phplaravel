<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetBook extends Model
{
    use HasFactory;

    protected $table = 'budget_books';
    protected $fillable = [
        'id',
        'description',
        'file'
    ];
}
