<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [''];

    function rel_to_color(){
        return $this->belongsTo(Color::class, 'color_id');
    }
    function rel_to_size(){
        return $this->belongsTo(Size::class, 'size_id');
    }
    function inventories(){
        return $this->hasMany(Inventory::class, 'product_id');
    }
    function rel_to_cat(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
