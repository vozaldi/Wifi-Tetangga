<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'icon', 'order', 'url', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'group_menus',
            'menu_id',
            'group_id',
            'id',
            'id',
        );
    }
}
