<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderproduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    function rel_to_customer(){
        return $this->belongsTo(CustomerLogin::class, 'user_id');
    }
    function rel_to_billing(){
        return $this->belongsTo(BillingDetails::class, 'order_id');
    }
    function rel_to_order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    function rel_to_color(){
        return $this->belongsTo(Color::class, 'color_id');
    }
    function rel_to_size(){
        return $this->belongsTo(Size::class, 'size_id');
    }

}
