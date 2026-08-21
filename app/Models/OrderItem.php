<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $guarded = [];
    public function order() { return $this->belongsTo(Order::class); }
    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function product() { return $this->belongsTo(Product::class); }
    public function option() { return $this->belongsTo(ProductOption::class, 'product_option_id'); }
}
