<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){
        $request->validate([
            'color_id'=>'required',
            'size_id'=>'required',
        ],[
            'color_id.required'=>'Please select a Color!',
            'size_id.required'=>'Please select a Size!',
        ]);
        // echo $request->size_id;
        //     die();
            if(Cart::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
                Cart::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity' ,$request->quantity);
                return back()->with('cart_added', 'Cart Added Successfully');
            }
            else{
                Cart::insert([
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                return back()->with('cart_added', 'Cart Added Successfully');
            }

    }

    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    // cart view
    function cart_view(Request $request){
        $coupon_code = $request->coupon;
        $massage = null;
        $type = null;
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        // $inventory_sum = Inventory::where('product_id' , $carts->product_id)->sum('quantity');
        // if(Cart::where('product_id' , $carts->product_id)->exist()){
            // if ($inventory_sum <= 0){
            //         Cart::where('product_id' , $carts->product_id)->delete();
            // }
        // }
        if($coupon_code == ''){
                        $discount = 0;
                        $amountone = 0;
                        $amounttwo = 0;
                        $discountone = 0;
                        $amountthree = 0;
                        $amountfour = 0;
                        $discounttwo = 0;
                        $amountfive = 0;
                        $amountsix = 0;
                        $discountthree = 0;
                        $amountseven = 0;
                        $amounteight = 0;
                        $discountfour = 0;
        }else{

              if(Coupon::where('coupon_name', $coupon_code)->exists()){

                    if(carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon_code)->first()->validity){
                        $massage = 'This Coupon Code is Expried';
                        $discount = 0;
                        $amountone = 0;
                        $amounttwo = 0;
                        $discountone = 0;
                        $amountthree = 0;
                        $amountfour = 0;
                        $discounttwo = 0;
                        $amountfive = 0;
                        $amountsix = 0;
                        $discountthree = 0;
                        $amountseven = 0;
                        $amounteight = 0;
                        $discountfour = 0;
                    }
                    else{
                        $discount = Coupon::where('coupon_name', $coupon_code)->first()->discount;
                        $amountone = Coupon::where('coupon_name', $coupon_code)->first()->amountone;
                        $amounttwo = Coupon::where('coupon_name', $coupon_code)->first()->amounttwo;
                        $discountone = Coupon::where('coupon_name', $coupon_code)->first()->discountone;
                        $amountthree = Coupon::where('coupon_name', $coupon_code)->first()->amountthree;
                        $amountfour = Coupon::where('coupon_name', $coupon_code)->first()->amountfour;
                        $discounttwo = Coupon::where('coupon_name', $coupon_code)->first()->discounttwo;
                        $amountfive = Coupon::where('coupon_name', $coupon_code)->first()->amountfive;
                        $amountsix = Coupon::where('coupon_name', $coupon_code)->first()->amountsix;
                        $discountthree = Coupon::where('coupon_name', $coupon_code)->first()->discountthree;
                        $amountseven = Coupon::where('coupon_name', $coupon_code)->first()->amountseven;
                        $amounteight = Coupon::where('coupon_name', $coupon_code)->first()->amounteight;
                        $discountfour = Coupon::where('coupon_name', $coupon_code)->first()->discountfour;
                        $type = Coupon::where('coupon_name', $coupon_code)->first()->type;
                    }
              }
              else{
                $massage = 'Invalid Coupon Code';
                        $discount = 0;
                        $amountone = 0;
                        $amounttwo = 0;
                        $discountone = 0;
                        $amountthree = 0;
                        $amountfour = 0;
                        $discounttwo = 0;
                        $amountfive = 0;
                        $amountsix = 0;
                        $discountthree = 0;
                        $amountseven = 0;
                        $amounteight = 0;
                        $discountfour = 0;
              }

        }


        return view('frontend.cart' , [
            'carts'=>$carts,
            'massage'=>$massage,
            'discount'=>$discount,
            'amountone'=>$amountone,
            'amounttwo'=>$amounttwo,
            'discountone'=>$discountone,
            'amountthree'=>$amountthree,
            'amountfour'=>$amountfour,
            'discounttwo'=>$discounttwo,
            'amountfive'=>$amountfive,
            'amountsix'=>$amountsix,
            'discountthree'=>$discountthree,
            'amountseven'=>$amountseven,
            'amounteight'=>$amounteight,
            'discountfour'=>$discountfour,
            'type'=>$type,
        ]);
    }

    function cart_update(Request $request){
            foreach($request->quantity as $cart_id=>$quantity){
                        Cart::find($cart_id)->update([
                            'quantity'=>$quantity,
                        ]);
                    }
        return back()->with('cart','Cart Updated Successfully');
    }
}
