<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;

class Variant extends Model
{
    protected $fillable = ['name'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
