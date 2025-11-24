<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['company_id', 'name'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
