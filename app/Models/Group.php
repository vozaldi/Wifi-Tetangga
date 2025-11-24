<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_groups')
            ->withPivot('company_id', 'branch_id')
            ->withTimestamps();
    }
}
