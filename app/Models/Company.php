<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email', 'logo'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
