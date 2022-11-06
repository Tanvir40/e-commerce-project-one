<?php

namespace App\Http\Controllers;

use App\Mail\SendInVoiceMail;
use App\Models\BillingDetails;
use App\Models\Orderproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    
    //orders_view
    function orders_view($order_id){
        $orders = Orderproduct::where('order_id',$order_id)->get();
        return view('admin.orders.order_view',[
            'orders'=>$orders,
        ]);
    }
    //update_status
    function update_status(Request $request){
        if($request->status == 'processing'){
            BillingDetails::find($request->order_id)->update([
                'status'=>$request->status,
            ]);
            return back()->with('processing' , 'Order Now In Processing');
        }
        if($request->status == 'delivered'){
            BillingDetails::find($request->order_id)->update([
                'status'=>$request->status,
                'trans_status'=>'payment received by COD ',
            ]);
             //for delivery success customer email
             Mail::to($request->email)->send(new SendInVoiceMail($request->order_id));
              //SMS sent to mobile code start

              $url = "http://66.45.237.70/api.php";
              $number=$request->phone;
              $text="Thanks for purchasing our products, your order is $request->order_id , and your total amount is : ".$request->grandtotal." and delivery charge is ".$request->charge.". You will get the products Soon, Thank you.";
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
            return back()->with('delevered' , 'Order Delevery Successfully');
        }
        if($request->status == 'cencel'){
            BillingDetails::find($request->order_id)->update([
                'status'=>$request->status,
            ]);
            //for cencel order customer email
            Mail::to($request->email)->send(new SendInVoiceMail($request->order_id));

             //SMS sent to mobile code start
             $url = "http://66.45.237.70/api.php";
             $number=$request->phone;
             $text="Your has been Cencelled, your order is $request->order_id , Thank you for your help.";
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
            return back()->with('cencel' , 'Order Cenceled');
        }
    }

    //all order 
    // public function all_order()
    // {
    //     $data = BillingDetails::orderBy('id','desc')->get();
    //     return response()->json($data);
    // }
    // BillingDetailsDataTable $dataTable
    public function all_order(Request $request){

        // return $dataTable->render('all_order');

        //return Datatables::of(BillingDetails::query())->make(true);

        $data = BillingDetails::get();

        if ($request->ajax()) {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('all_order');
    }
    
    //pending_orders
    function pending_orders(Request $request){
        $orders = BillingDetails::where('status' , 'pending')->get();
        return view('admin.orders.pen_ord', [
            'orders'=>$orders,
        ]);
    }

    //processing_orders
    function processing_orders(Request $request){
        $orders = BillingDetails::where('status' , 'processing')->get();
        return view('admin.orders.pro_ord', [
            'orders'=>$orders,
        ]);
    }
    //delivered_orders
    function delivered_orders(Request $request){
        $orders = BillingDetails::where('status' , 'delivered')->get();
        return view('admin.orders.del_ord', [
            'orders'=>$orders,
        ]);
    }
    //cencel_orders
    function cencel_orders(Request $request){
        $orders = BillingDetails::where('status' , 'cencel')->get();
        return view('admin.orders.cen_ord', [
            'orders'=>$orders,
        ]);
    }
}
