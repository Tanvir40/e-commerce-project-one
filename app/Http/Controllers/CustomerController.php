<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerLogin;
use App\Models\CustomerPasswordReset;
use App\Models\CustomrForm;
use App\Models\Order;
use App\Models\Orderproduct;
use App\Notifications\PasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;
use Illuminate\Support\Facades\Notification;

class CustomerController extends Controller
{
    function customer_account(){
        $orders = Order::where('user_id' , Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer', [
            'orders'=>$orders,
        ]);
    }

    function customer_account_update(Request $request){
            if($request->password == ''){
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                ]);
                return back();
            }else{
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                ]);
                return back();
            }

    }
    //customer cencel order
        function update_status(Request $request){
            if($request->status == 'cencel'){
                BillingDetails::find($request->order_id)->update([
                    'status'=>$request->status,
                ]);
                return back();
            }
        }
    //order invoice download
    function invoice_download($order_id){
        return view('invoice.invoice',[
            'order_id'=>$order_id,
        ]);
        // $pdf = PDF::loadView('invoice.invoice', [
        //     'order_id'=>$order_id,
        // ]);
        // return $pdf->stream('invoice.pdf');
    }

    //customer password reset
    function pass_reset(){
        return view('pass_reset');
    }

    function pass_reset_link(Request $request){
        $customer = CustomerLogin::where('email' , $request->email)->firstOrFail();
        $password_reset = CustomerPasswordReset::where('customer_id' , $customer->id)->delete();

        $password_reset = CustomerPasswordReset::create([
            'customer_id'=>$customer->id,
            'reset_token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new PasswordResetNotification($password_reset));

        return back()->with('reset_link', 'Reset link sent  to your Email address');
    }

    //customer password reset form
    function pass_reset_form($token){
        return view('pass_reset_form',[
            'token'=>$token,
        ]);
    }

    //customer password update
    function pass_reset_update(Request $request){
        $customer_token = CustomerPasswordReset::where('reset_token' , $request->reset_token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($customer_token->customer_id);

        $customer->update([
            'password'=>Hash::make($request->password),
        ]);
        $customer_token->delete();
        return back()->with('reset_success', 'Password reset successfully');
    }


        //customer form
        function customer_form(Request $request){
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'subject'=>'required',
                'message'=>'required',
            ],[
                'name.required'=>'Please Enter Your Name!',
                'email.required'=>'Please Enter a Email!',
                'subject.required'=>'Subject Is Required!',
                'message.required'=>'Tell Us your Opinion!',
            ]);

            CustomrForm::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'subject'=>$request->subject,
                'message'=>$request->message,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('form_success' , 'Your Queries has been Submitted');
        }

        //customer form view
        function customer_form_view(){
            $customer_form = CustomrForm::paginate(10);
            return view('admin.customer_form', [
                'customer_form'=>$customer_form,
            ]);
        }

        //customer form delete
        function customer_form_delete($id){
            CustomrForm::find($id)->delete();
            return back()->with('delete', 'Form Deleted Successfully!');
        }

        //customer list delete
        function customer_list_delete($id){
            CustomerLogin::find($id)->delete();
            return back()->with('delete', 'Customer Deleted Successfully!');
        }

        
}
