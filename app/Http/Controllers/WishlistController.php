<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
      //wishlist view
    function wishlist(){
        $wishlists = Wishlist::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.wishlist' , [
            'wishlists'=>$wishlists,
        ]);
    }

    //wishlist insert
    function wishlist_store(Request $request){
        if(Wishlist::where('product_id',$request->product_id)->exists()){
            return back()->with('wishlist_exist', 'Favourite Already Added');
        }
        else{
            Wishlist::insert([
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'product_id'=>$request->product_id,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('wishlist_added', 'Favourite Added Successfully');
        }
    }

    //wishlist remove
    function wishlist_remove($wishlist_id){
        Wishlist::find($wishlist_id)->delete();
        return back();
    }



}
