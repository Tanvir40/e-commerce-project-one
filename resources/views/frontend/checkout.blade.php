@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Check Out</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->
            <!-- checkout-section - start
            ================================================== -->
            <section class="checkout-section section_space">
                @if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() > 0 )

               <div class="container">
                  <div class="row">
                     <div class="col col-xs-12">
                        <div class="woocommerce bg-light p-3">
                           <form  method="post" class="checkout woocommerce-checkout" action="{{route('checkout.insert')}}">@csrf
                            <input type="hidden"  name="user_id" value="{{Auth::guard('customerlogin')->id()}}">
                              <div class="col2-set" id="customer_details">
                                 <div class="coll-1">
                                    <div class="woocommerce-billing-fields">
                                       <h3>Billing Details</h3>
                                       <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field">
                                        @error('name')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                          <label for="billing_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label>
                                          <input type="text" class="input-text " name="name" id="billing_first_name" placeholder="" autocomplete="given-name" readonly value="{{Auth::guard('customerlogin')->user()->name}}" />
                                       </p>
                                       <p class="form-row form-row form-row-last validate-required validate-email" id="billing_email_field">
                                          <label for="billing_email" class="">Email Address <abbr class="required" title="required">*</abbr></label>
                                          <input type="email" class="input-text" name="email" id="billing_email" readonly autocomplete="email" value="{{Auth::guard('customerlogin')->user()->email}}" />
                                          @error('email')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>
                                       <div class="clear"></div>
                                       <p class="form-row form-row form-row-first" id="billing_company_field">
                                          <label for="billing_company" class="">Company Name</label>
                                          <input type="text" class="input-text " name="company" id="billing_company" placeholder="" autocomplete="organization" value="No Company" />
                                          @error('company')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>

                                       <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
                                          <label for="billing_phone" class="">Phone <abbr class="required" title="required">*</abbr></label>
                                          <input type="text" class="input-text " name="phone" id="billing_phone" placeholder="" autocomplete="tel" value="" />
                                          @error('phone')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>
                                       <div class="clear"></div>
                                       <p class="form-row form-row form-row-first address-field update_totals_on_change validate-required" id="billing_country_field">
                                          <label class="form-label">Country</label>
                                          <select name="country_id" class="form-control" id="country_id">
                                             <option value="">Select a country&hellip;</option>
                                             @foreach ($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                             @endforeach
                                          </select>
                                          @error('country_id')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>
                                       <p class="form-row form-row form-row-last address-field update_totals_on_change validate-required" id="billing_country_field">
                                        <label class="form-label">City</label>
                                          <select name="city_id" class="form-control" id="city_id">
                                             <option value="">Select a City&hellip;</option>
                                          </select>
                                          @error('city_id')
                                          <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                       </p>
                                       <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                                          <label for="billing_address_1" class="">Address <abbr class="required" title="required">*</abbr></label>
                                          <input type="text" class="input-text " name="address" id="billing_address_1" placeholder="Street address" autocomplete="address-line1" value="" />
                                          @error('address')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>
                                    </div>
                                    <p class="form-row form-row notes" id="order_comments_field">
                                          <label for="order_comments" class="">Order Notes</label>
                                          <textarea name="order_comments" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                          @error('order_comments')
                                            <strong class="text-danger">{{$message}}</strong>
                                          @enderror
                                       </p>
                                 </div>
                              </div>
                              <h3 id="order_review_heading">Your order</h3>
                              @php
                                  $subtotal = 0;
                                  foreach(App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->get() as $cart){
                                    $subtotal += $cart->rel_to_product->after_discount * $cart->quantity;
                                  }
                              @endphp
                              <div id="order_review" class="woocommerce-checkout-review-order">
                                 <table class="shop_table woocommerce-checkout-review-order-table">
                                       <tr class="cart-subtotal">
                                          <th>Subtotal</th>
                                          <td><span class="woocommerce-Price-amount amount" id="subtotal">{{$subtotal}}</span>
                                          </td>
                                       </tr>
                                       <tr class="cart-subtotal">
                                          <th>Discount</th>
                                          <td>-<span class="woocommerce-Price-amount amount" id="discount">{{session('discount_final')}}</span>
                                          </td>
                                       </tr>
                                       <tr class="shipping">
                                          <th>Delivery Charge</th>
                                          <td data-title="Shipping">
                                              <input type="hidden" value="{{session('discount_final')}}" name="discount">
                                              <input type="hidden" value="{{$subtotal}}" name="subtotal">
                                            <input type="radio" name="charge" class="delivery_btn"  value="{{(App\Models\Cart::where('customer_id' , $cart->customer_id)->sum('cart_item'))*60}}">Dhaka  (+60) x {{App\Models\Cart::where('customer_id' , $cart->customer_id)->sum('cart_item')}}
                                            <br>
                                            <input type="radio" name="charge" class="delivery_btn"  value="{{(App\Models\Cart::where('customer_id' , $cart->customer_id)->sum('cart_item'))*120}}">Outside Dhaka   (+120) x {{App\Models\Cart::where('customer_id' , $cart->customer_id)->sum('cart_item')}}
                                            @error('charge')
                                                <strong class="text-danger">{{$message}}</strong>
                                            @enderror
                                          </td>

                                       </tr>
                                       <tr class="order-total">
                                          <th>Total</th>
                                          <td><strong><span class="woocommerce-Price-amount amount" id="grand_total">{{$subtotal - session('discount_final')}}</span></strong> </td>
                                       </tr>
                                 </table>
                                 <div id="payment" class="woocommerce-checkout-payment py-3 mt-5">
                                    <ul class="wc_payment_methods payment_methods methods">
                                       <li class="wc_payment_method payment_method_cheque mb-2">
                                          <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="1" checked='checked' data-order_button_text="" />
                                          <!--grop add span for radio button style-->
                                          <span class='grop-woo-radio-style'></span>
                                          <!--custom change-->
                                          <label for="payment_method_cheque">Cash On Delivery</label>
                                       </li>
                                       <li class="wc_payment_method payment_method_paypal mb-2">
                                          <input id="payment_method_ssl" type="radio" class="input-radio" name="payment_method" value="2" data-order_button_text="Proceed to SSL Commerz" />
                                          <!--grop add span for radio button style-->
                                          <span class='grop-woo-radio-style'></span>
                                          <!--custom change-->
                                          <label for="payment_method_ssl">SSL Commerz</label>
                                       </li>
                                       <li class="wc_payment_method payment_method_paypal">
                                          <input id="payment_method_stripe" type="radio" class="input-radio" name="payment_method" value="3" data-order_button_text="Proceed to SSL Commerz" />
                                          <!--grop add span for radio button style-->
                                          <span class='grop-woo-radio-style'></span>
                                          <!--custom change-->
                                          <label for="payment_method_stripe">Stripe Payment</label>
                                       </li>
                                       <li class="wc_payment_method payment_method_paypal">
                                          <input id="bkash_button" type="radio" class="input-radio" name="payment_method" value="4" data-order_button_text="Proceed to SSL Commerz" />
                                          <!--grop add span for radio button style-->
                                          <span class='grop-woo-radio-style'></span>
                                          <!--custom change-->
                                          <label for="payment_method_stripe">Bkash Payment</label>
                                       </li>
                                       <li class="wc_payment_method payment_method_paypal">
                                          <input id="bkash_button" type="radio" class="input-radio" name="payment_method" value="5" data-order_button_text="Proceed to Paypal" />
                                          <!--grop add span for radio button style-->
                                          <span class='grop-woo-radio-style'></span>
                                          <!--custom change-->
                                          <label for="payment_method_stripe">Paypal Payment</label>
                                       </li>
                                   
                                    </ul>
                                    <div class="form-row place-order">
                                       <noscript>
                                          Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.
                                          <br/>
                                          <input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Update totals" />
                                       </noscript>
                                       <input type="submit" class="button alt" id="place_order" value="Place order"/>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            @else
            <!-- empty_checkout_section - start
            ================================================== -->
            <section class="empty_cart_section section_space">
                <div class="container">
                    <div class="empty_cart_content text-center">
                        <span class="cart_icon">
                            <i class="icon icon-ShoppingCart"></i>
                        </span>
                        <h3>There are nothing to checkout</h3>
                        <a class="btn btn_secondary" href="{{route('index')}}"><i class="fa fa-chevron-left"></i> Continue shopping </a>
                    </div>
                </div>
            </section>
            <!-- empty_checkout_section - end
            ================================================== -->
                @endif
            <!-- checkout-section - end
            ================================================== -->

@endsection

@section('footer_script')
<script>
$('.delivery_btn').click(function(){
    var charge = $(this).val();
     var subtotal = $('#subtotal').html();
     var discount = $('#discount').html();
     var total = subtotal - discount + (parseInt(charge));
    $('#grand_total').html(total);
});
//select 2 js
$(document).ready(function() {
    $('#country_id').select2();
});
//select 2 js
$(document).ready(function() {
    $('#city_id').select2();
});
</script>

<script>
//get category

    $('#country_id').change(function(){

        var country_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getCity',
            data:{'country_id':country_id},
            success:function(data){
                $('#city_id').html(data);
                $('#city_id').select2();
            }
        });

    });
</script>

@endsection
