<?php

namespace App\Http\Controllers;

use App\Mail\SendInVoiceMail;
use App\Models\BillingDetails;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Orderproduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    //checkout view
    function checkout(){
        $countries = Country::all();
        $cities = City::all();
        return view('frontend.checkout',[
            'countries'=>$countries,
            'cities'=>$cities,
        ]);
    }

    //checkout country-city ajax
    function getCity(Request $request){
        $cities = City::where('country_id', $request->country_id)->get();
        $str ='<option value="">-- select city--</option>';
        foreach($cities as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    //checkout insert
    function checkout_insert(Request $request){
        $request->validate([
            'company'=>'required',
            'phone'=>'required',
            'country_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'order_comments'=>'required',
            'charge'=>'required',
        ],[
            'company.required'=>'Please Enter Your Company Name!',
            'phone.required'=>'Please Enter Your Phone Number!',
            'country_id.required'=>'Please select Your Country!',
            'city_id.required'=>'Please select Your City!',
            'address.required'=>'Please Enter Your Addess!',
            'order_comments.required'=>'Your Comment Required!',
            'charge.required'=>'Please select one Area!',
        ]);

        if($request->payment_method == 1){
           $order_id = Order::insertGetId([
                'user_id'=>Auth::guard('customerlogin')->id(),
                'subtotal'=>$request->subtotal,
                'discount'=>$request->discount,
                'charge'=>$request->charge,
                'total'=>$request->subtotal + $request->charge - ($request->discount),
                'order_date' => Carbon::now()->format('d F Y'),
                'order_month' => Carbon::now()->format('F'),
                'order_year' => Carbon::now()->format('Y'),
                'created_at'=>Carbon::now(),
            ]);
            BillingDetails::insert([
                'user_id'=>Auth::guard('customerlogin')->id(),
                'order_id'=>$order_id,
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'company'=>$request->company,
                'country_id'=>$request->country_id,
                'city_id'=>$request->city_id,
                'address'=>$request->address,
                'order_comments'=>$request->order_comments,
                'payment_status'=>'COD',
                'trans_status'=>'Payment Due',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach($carts as $cart){
                Orderproduct::insert([
                    'user_id'=>Auth::guard('customerlogin')->id(),
                    'order_id'=>$order_id,
                    'product_id'=>$cart->product_id,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'price'=>$cart->rel_to_product->after_discount,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);
            }
            //for customer email
            Mail::to($request->email)->send(new SendInVoiceMail($order_id));
            //for admin email
            Mail::to('tonmoy1998441@gmail.com')->send(new SendInVoiceMail($order_id));

            $total_amount = $request->subtotal + $request->charge - ($request->discount);
            $total_product = $cart->quantity;
            $charge = $request->charge;
            $order_id ;

            //SMS sent to mobile code start

                $url = "http://66.45.237.70/api.php";
                $number=$request->phone;
                $text="Thanks for purchasing our products, your order is $order_id , and your total amount is : ".$total_amount." and delivery charge is ".$charge." , For ".$total_product." items. You will get the products Soon, Thank you.";
                $data= array(
                'username'=>"tonmoy44",
                'password'=>"ZPERXW6B",
                'number'=>"$number",
                'message'=>"$text"
                );

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                $p = explode("|",$smsresult);
                $sendstatus = $p[0];

            //SMS sent to mobile code end


            foreach($carts as $cart){
                Cart::find($cart->id)->delete();
            }
            foreach($carts as $cart){
                Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity' ,$cart->quantity);
            }

            return redirect()->route('order.success')->with('order_success' , 'Your Order Has Been Placed!');
        }
        elseif($request->payment_method == 2){
            $data = $request->all();
            return view('exampleHosted' ,[
                'data'=>$data,
            ]);
        }
        elseif($request->payment_method == 4){
            $data = $request->all();
            return view('bkash-payment' ,[
                'data'=>$data,
            ]);
        }
        elseif($request->payment_method == 5){
            $data = $request->all();
            return view('myOrder' ,[
                'data'=>$data,
            ]);
        }
        else{
            $data =$request->all();
            return view('stripe',[
                'data'=>$data,
            ]);
        }

    }

    //order success
    function order_success(){
        if(session('order_success')){
            return view('frontend.order_success');
        }
        else{
            abort('404');
        }

    }


}
