<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInVoiceMail;
use App\Models\BillingDetails;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Orderproduct;
use Carbon\Carbon;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Notification;


class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');

            } else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');

    }

    public function getPaymentStatus()
    {
        
        $request=request();//try get from method

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        //if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        if (empty($request->PayerID) || empty($request->token)) {

            Session::put('error', 'Payment failed');
            return Redirect::to('/');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        //$execution->setPayerId(Input::get('PayerID'));
        $execution->setPayerId($request->PayerID);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            
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
            'payment_status'=>'Paypal',
            'trans_status'=>$payment_id,
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

            Session::put('success', 'Payment success');
            //add update record for cart
            return view('frontend.order_success');  //back to product page

        
    

        Session::put('error', 'Payment failed');
        return Redirect::to('/'); 

    }

}