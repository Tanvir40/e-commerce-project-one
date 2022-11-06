<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\UptoDiscountCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //coupon
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }

    //coupon add
    function coupon_add(Request $request){
        $request->validate([
            'coupon_name'=>'required',
            'type'=>'required',
            'validity'=>'required',
        ]);

        if(Coupon::where('coupon_name' , $request->coupon_name)->exists()){
            return back()->with('exist' , 'Coupon Already Exist in this Coupon List');
        }
        else{
            Coupon::insert([
                'coupon_name'=>$request->coupon_name,
                'discount'=>$request->discount,
                'amountone'=>$request->amountone,
                'amounttwo'=>$request->amounttwo,
                'discountone'=>$request->discountone,
                'amountthree'=>$request->amountthree,
                'amountfour'=>$request->amountfour,
                'discounttwo'=>$request->discounttwo,
                'amountfive'=>$request->amountfive,
                'amountsix'=>$request->amountsix,
                'discountthree'=>$request->discountthree,
                'amountseven'=>$request->amountseven,
                'amounteight'=>$request->amounteight,
                'discountfour'=>$request->discountfour,
                'type'=>$request->type,
                'validity'=>$request->validity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'Coupon Added Successfully!');
        }
    }

    //coupon edit
    function coupon_edit($coupon_id){
        $coupons = Coupon::find($coupon_id);
        return view('admin.coupon.edit',[
            'coupons'=>$coupons,
        ]);
        return back()->with('success', 'Coupons Added Successfully!');
    }

    //coupon update
    function coupon_update(Request $request){
        // recuired validation
        if($request->upto_coupon_id){
            $request->validate([
                'coupon_name'=>'required',
                'amountone'=>'required',
                'amounttwo'=>'required',
                'discountone'=>'required',
                'amountthree'=>'required',
                'amountfour'=>'required',
                'discounttwo'=>'required',
                'amountfive'=>'required',
                'amountsix'=>'required',
                'discountthree'=>'required',
                'amountseven'=>'required',
                'amounteight'=>'required',
                'discountfour'=>'required',
                'type'=>'required',
                'validity'=>'required',
            ]);
        }
        else{
            $request->validate([
                'coupon_name'=>'required',
                'type'=>'required',
                'validity'=>'required',
            ]);
        }


        //coupon update
            if($request->coupon_id){
                    Coupon::find($request->coupon_id)->update([
                    'coupon_name'=>$request->coupon_name,
                    'discount'=>$request->discount,
                    'type'=>$request->type,
                    'validity'=>$request->validity,
                    'updated_at'=>Carbon::now(),
                ]);
            }
            else{
                Coupon::find($request->upto_coupon_id)->update([
                    'coupon_name'=>$request->coupon_name,
                    'amountone'=>$request->amountone,
                    'amounttwo'=>$request->amounttwo,
                    'discountone'=>$request->discountone,
                    'amountthree'=>$request->amountthree,
                    'amountfour'=>$request->amountfour,
                    'discounttwo'=>$request->discounttwo,
                    'amountfive'=>$request->amountfive,
                    'amountsix'=>$request->amountsix,
                    'discountthree'=>$request->discountthree,
                    'amountseven'=>$request->amountseven,
                    'amounteight'=>$request->amounteight,
                    'discountfour'=>$request->discountfour,
                    'type'=>$request->type,
                    'validity'=>$request->validity,
                    'updated_at'=>Carbon::now(),
                ]);
            }
            return redirect()->route('coupon')->with('edit', 'Coupon Edited Successfully!');

    }
    //coupon delete
    function coupon_delete($coupon_id){
        Coupon::find($coupon_id)->delete();
        return back()->with('delete', 'Coupon Deleted Successfully');
    }
}
