<?php

namespace App\Http\Controllers;

use App\Models\Orderproduct;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  //show review
    function show_review(){
        $reviews = Orderproduct::where('review', '!=', null)->paginate(10);
        return view('admin.customer_reviews',[
            'reviews'=>$reviews,
        ]);
    }
}
