<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetails extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    function rel_to_order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    function rel_to_orderproduct(){
        return $this->hasMany(Orderproduct::class, 'order_id');
    }
    function rel_to_country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    function rel_to_city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
