<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Branch;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'company_id', 'branch_id', 'name', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
