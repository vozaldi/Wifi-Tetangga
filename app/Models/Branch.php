<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['company_id', 'name', 'address', 'phone'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
