<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function refund() {
        return $this->hasMany(Refund::class);
    }

    protected $fillable = [
        'product_id', 'quantity', 'price', 'sold_at'
    ];
}
