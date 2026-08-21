<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model {
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get effective price for this variant (variant price if set, otherwise product base price).
     */
    public function getEffectivePriceAttribute() {
        return $this->price !== null ? $this->price : ($this->product ? $this->product->price : 0);
    }
}
