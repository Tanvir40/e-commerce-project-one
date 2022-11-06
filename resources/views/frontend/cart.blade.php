@extends('frontend.master')
@section('content')
  <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->
            <!-- cart_section - start
            ================================================== -->

            <section class="cart_section section_space">
                @if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() > 0 )
                <div class="container">
                    <div class="cart_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                    $abc = true;
                                @endphp
                                @foreach ($carts as $cart)
                                <tr>
                                    <td>
                                        <div class="cart_product">
                                            <a href="{{route('product.details', $cart->product_id)}}"><img src="{{asset('/uploads/products/preview/')}}/{{$cart->rel_to_product->preview}}" alt="image_not_found"></a>
                                            <a href="{{route('product.details', $cart->product_id)}}"><h3>{{$cart->rel_to_product->product_name}}</h3></a>
                                        </div>
                                        <p class="text-dark">Maximum Order Quantity {{App\Models\Inventory::where('product_id' , $cart->product_id)->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->quantity}}</p>
                                    </td>
                                    <td class="text-center abc"><span class="price_text">TK: {{$cart->rel_to_product->after_discount}}</span></td>

                                    <td class="text-center abc">
                                        <form action="{{route('cart.update')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$cart->product_id}}">
                                            <div class="quantity_input">
                                                <button type="button" class="input_number_decrement">
                                                    <i data-price="{{$cart->rel_to_product->after_discount}}" class="fa fa-minus"></i>
                                                </button>
                                                <input class="input_number" name="quantity[{{$cart->id}}]" type="text" value="{{$cart->quantity}}" />
                                                <button type="button" class="input_number_increment">
                                                    <i data-price="{{$cart->rel_to_product->after_discount}}" class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                    </td>
                                    <td class="text-center abc"><span class="price_text">TK: {{$cart->rel_to_product->after_discount*$cart->quantity}}</span></td>
                                    <td>
                                        @if(App\Models\Inventory::where('product_id' , $cart->product_id)->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->quantity < $cart->quantity)
                                            <span class="badge bg-warning">Stock Out</span>
                                            @php
                                            $abc = false;
                                        @endphp
                                        @else
                                            <span class="badge bg-success">Stock In</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="{{route('cart.remove', $cart->id)}}" class="remove_btn"><i class="fa fa-trash"></i></a></td>
                                </tr>

                                @php
                                    $subtotal += $cart->rel_to_product->after_discount*$cart->quantity;
                                @endphp

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="cart_btns_wrap">
                        <div class="row">
                            @php
                                if ($type == 'percentage'){
                                    $discount_final = ($subtotal*$discount)/100;
                                }
                                else if($type == 'upto'){
                                        if($subtotal >= $amountone && $subtotal <= $amounttwo){
                                            $discount_final = $discountone;
                                        }
                                        else if ($subtotal >= $amountthree && $subtotal <= $amountfour) {
                                            $discount_final = $discounttwo;
                                        }
                                        else if ($subtotal >= $amountfive && $subtotal <= $amountsix) {
                                            $discount_final = $discountthree;
                                        }
                                        else if ($subtotal >= $amountseven && $subtotal <= $amounteight) {
                                            $discount_final = $discountfour;
                                        }
                                        else{
                                            $discount_final = $discountfour;
                                        }
                                }
                                else{
                                    $discount_final = $discount;
                                }
                            @endphp

                            @php
                                session([
                                    'discount_final'=>$discount_final,
                            ])
                            @endphp
                            <div class="col col-lg-12">
                                <ul class="btns_group ul_li_right">

                                        <li><button class="btn border_black" type="submit">Update Cart</button></li>
                                            @if ($abc == true)
                                            <li><a class="btn btn_dark" href="{{route('checkout')}}">Prceed To Checkout</a></li>
                                            @else
                                            <p class="alert alert-warning">Remove the Stock out Item</p>
                                            @endif
                                </ul>
                            </form>
                            </div>

                        </div>
                    </div>

                <div class="cart_btns_wrap">
                    <div class="row">
                        <div class="col col-lg-6">
                            @if ($massage)
                                <div class="alert alert-danger">{{$massage}}</div>
                            @endif
                            <form action="{{url('/cart/')}}" method="GET">
                                <div class="coupon_form form_item mb-0">
                                    <input type="text" name="coupon" placeholder="Coupon Code..." value="{{@$_GET['coupon']}}">
                                    <button type="submit" class="btn btn_dark">Apply Coupon</button>
                                    <div class="info_icon">
                                        <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Info Here"></i>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="col col-lg-6">
                            <div class="cart_total_table">
                                <h3 class="wrap_title">Cart Totals</h3>
                                <ul class="ul_li_block">
                                    <li>
                                        <span>Cart Subtotal</span>
                                        <span>{{$subtotal}} BDT</span>
                                    </li>
                                    <li>
                                        <span>Discount Price</span>
                                        <span>{{$discount_final}} BDT
                                        @if ($type == 'percentage')
                                            (You Get {{$discount}} % Discount)
                                        @endif
                                        </span>
                                    </li>
                                    <li>
                                        <span>Order Total</span>
                                        <span class="total_price">{{$subtotal - $discount_final}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @else
            <!-- empty_cart_section - start
            ================================================== -->
            <section class="empty_cart_section section_space">
                <div class="container">
                    <div class="empty_cart_content text-center">
                        <span class="cart_icon">
                            <i class="icon icon-ShoppingCart"></i>
                        </span>
                        <h3>There are no more items in your cart</h3>
                        <a class="btn btn_secondary" href="{{route('index')}}"><i class="fa fa-chevron-left"></i> Continue shopping </a>
                    </div>
                </div>
            </section>
            <!-- empty_cart_section - end
            ================================================== -->
                @endif
            </section>
            <!-- cart_section - end
            ================================================== -->
@endsection

@section('footer_script')
<script>
    let quantity_input = document.querySelectorAll('.abc');
    let arr = Array.from(quantity_input);

    arr.map(item=>{
        item.addEventListener('click', function(e){
            if(e.target.className == 'fa fa-plus'){
                e.target.parentElement.previousElementSibling.value++
                let quantity = e.target.parentElement.previousElementSibling.value
                let price = e.target.dataset.price;
                item.nextElementSibling.innerHTML = price*quantity
            }
            if(e.target.className == 'fa fa-minus'){
                if(e.target.parentElement.nextElementSibling.value > 1){
                e.target.parentElement.nextElementSibling.value--
                let quantity = e.target.parentElement.nextElementSibling.value
                let price = e.target.dataset.price;
                item.nextElementSibling.innerHTML = price*quantity
                }
            }
        });
    });

</script>

@endsection
