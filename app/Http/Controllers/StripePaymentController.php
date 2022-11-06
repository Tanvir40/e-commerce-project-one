<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Mail\SendInVoiceMail;
use App\Models\BillingDetails;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Orderproduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      $stripe =  Stripe\Charge::create ([
                "amount" => $request->total * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);
        $data = session('data');

        $order_id = Order::insertGetId([
            'user_id'=>$data['user_id'],
            'subtotal'=>$data['subtotal'],
            'discount'=>$data['discount'],
            'charge'=>$data['charge'],
            'total'=>$data['subtotal'] + $data['charge'] - ($data['discount']),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'created_at'=>Carbon::now(),
        ]);
        BillingDetails::insert([
            'user_id'=>$data['user_id'],
            'order_id'=>$order_id,
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'company'=>$data['company'],
            'country_id'=>$data['country_id'],
            'city_id'=>$data['city_id'],
            'address'=>$data['address'],
            'order_comments'=>$data['order_comments'],
            'payment_status'=>'STRIPE',
            'trans_status'=>$stripe->payment_method,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        $carts = Cart::where('customer_id', $data['user_id'])->get();
        foreach($carts as $cart){
            Orderproduct::insert([
                'user_id'=>$data['user_id'],
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
            $number=$data['phone'];
            $text="Thanks for purchasing our products,your order is $order_id , and your total amount is : ".$total_amount." and delivery charge is ".$charge." , For ".$total_product." items. You will get the products Soon, Thank you.";
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
}
