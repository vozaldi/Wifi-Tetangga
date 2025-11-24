<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\ProductVariant;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id', 'product_variant_id', 'description', 'quantity', 'price', 'total'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
