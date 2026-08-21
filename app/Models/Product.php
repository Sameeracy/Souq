<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $guarded = [];
    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function options() { return $this->hasMany(ProductOption::class); }
}
