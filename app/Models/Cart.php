<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function option() {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

    /**
     * Calculate effective price considering custom variant pricing.
     */
    public function getEffectivePriceAttribute() {
        if ($this->option && $this->option->price !== null) {
            return (float)$this->option->price;
        }
        return $this->product ? (float)$this->product->price : 0.0;
    }
}
