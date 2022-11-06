<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Childcategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [''];
    function rel_to_subcategory(){
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
