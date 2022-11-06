<?php

namespace App\Http\Controllers;

use App\Mail\PromotionEmail;
use App\Models\Customer_email;
use App\Models\Customer_number;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PromotionController extends Controller
{
    //email promotion
    function email_promotion(){
        $emails = Customer_email::get();
        return view('admin.promotion.email_promo' ,[
            'emails'=>$emails,
        ]);
    }

    //add email
    function insert_email(Request $request){
        $request->validate([
            'customer_email'=>'required|unique:customer_emails',
        ]);
        Customer_email::insert([
            'customer_email'=>$request->customer_email,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('added_success' , 'Newsletter Signup Successfully');
    }

    //send_promo_email
    function send_promo_email(Request $request){
        $customers = Customer_email::get();
        $write_email = $request->write_email;
        foreach($customers as $customer){
            Mail::to($customer->customer_email)->send(new PromotionEmail($write_email));
        }
        return back()->with('Sent_success' , 'Newsletter Email Sent Successfully');
    }

    //add number
    function insert_number(Request $request){
        $request->validate([
            'customer_number'=>'required|unique:customer_numbers',
        ]);
        Customer_number::insert([
            'customer_number'=>$request->customer_number,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('added_success' , 'Number Added Successfully');
    }
    //sms promotion
    function sms_promotion(){
        $numbers = Customer_number::get();
        return view('admin.promotion.sms_promo',[
            'numbers'=>$numbers,
        ]);
    }

    //send_promo_sms
    function send_promo_sms(Request $request){
        $number = Customer_number::get();
        foreach($number as $num){
            //SMS sent to mobile code start
            $url = "http://66.45.237.70/api.php";
            $number=$num->customer_number;
            $text=$request->write_sms;
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

        }
        return back()->with('Sent_success' , 'SMS Sent Successfully');
    }

    //email delete
    function email_delete($email_id){
        Customer_email::find($email_id)->delete();
        return back()->with('delete', 'Email Deleted Successfully');
    }

    //sms delete
    function sms_delete($sms_id){
        Customer_number::find($sms_id)->delete();
        return back()->with('delete', 'Number Deleted Successfully');
    }
}
