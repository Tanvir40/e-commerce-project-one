<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;
use Illuminate\Validation\Rules\Password;

class CustomerRegisterController extends Controller
{
    function customer_register(){
        return view('frontend.customer_register');
    }


    function customer_insert(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ],[
            'name.required'=>'Customer Name Required!',
            'email.required'=>'Customer E-mail Required!',
            'password.required'=>'Please Enter a Password!',
        ]);
        if(CustomerLogin::where('email' , $request->email)->exists()){
            return back()->with('exist' , 'Email Already Registered');
        }else{
            CustomerLogin::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'created_at'=>Carbon::now(),
            ]);
        }


        $customer = CustomerLogin::where('email' , $request->email)->firstOrFail();
        $delete_info = CustomerEmailVerify::where('customer_id' , $customer->id)->delete();

        $verify_info = CustomerEmailVerify::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer , new CustomerEmailVerifyNotification($verify_info));

        return back()->with('email_verify' , 'We have sent a verification link at->'.$customer->email);
    }

    function email_verify($token){
        $token_check = CustomerEmailVerify::where('token', $token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($token_check->customer_id);

        $customer->update([
            'email_verified_at'=>Carbon::now(),
        ]);

        $token_check->delete();

        return redirect()->route('customer.register')->with('verified', 'Congratulations Your Email Has Been Verified');
    }
}
