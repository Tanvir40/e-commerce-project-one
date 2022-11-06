<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    function rel_to_billing(){
        return $this->belongsTo(BillingDetails::class, 'order_id');
    }
    function rel_to_order_product(){
        return $this->hasMany(Orderproduct::class, 'order_id');
    }
}
