<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menu';
    protected $fillable = [
        'main_menu_id',
        'submenu_title',
        'submenu_link',        
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];

}
