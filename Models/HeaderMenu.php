<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    use HasFactory;
    protected $table = 'header_menu';
    protected $fillable = [
        'menu_title',
        'menu_link',        
        'lang_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getsub_menu()
    {
        return $this->hasMany(SubMenu::class,'main_menu_id','id');
    }
}
