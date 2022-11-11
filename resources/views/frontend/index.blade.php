@extends('frontend.master')
@section('content')
            <!-- slider_section - start
            ================================================== -->
            <section class="slider_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 offset-lg-3">
                            <div class="main_slider" data-slick='{"arrows": false}'>
                                @foreach ($carousel_image as $carousel)
                                    @if ($carousel->status == 1)
                                        <div class="slider_item set-bg-image" data-background="{{asset('front/images/slider')}}/{{$carousel->carousel_image}}">
                                            <div class="slider_content">
                                                <h3 class="small_title" data-animation="fadeInUp2" data-delay=".2s">{{$carousel->small_text}}</h3>
                                                <h4 class="big_title" data-animation="fadeInUp2" data-delay=".4s">{{$carousel->thin_large_text}}  <span>{{$carousel->thik_large_text}}</span></h4>
                                                <p data-animation="fadeInUp2" data-delay=".6s">{{$carousel->small_title}}</p>
                                                <div class="item_price" data-animation="fadeInUp2" data-delay=".6s">
                                                    <del>{{$carousel->price}}</del>
                                                    <span class="sale_price">{{$carousel->discount_price}}</span>
                                                </div>
                                                <a class="btn btn_primary" href="{{$carousel->product_url}}" data-animation="fadeInUp2" data-delay=".8s">Start Buying</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- slider_section - end
            ================================================== -->

            <!-- policy_section - start
            ================================================== -->
            <section class="policy_section">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="policy-wrap">
                                <div class="policy_item">
                                    <div class="item_icon">
                                        <i class="icon icon-Truck"></i>
                                    </div>
                                    <div class="item_content">
                                        <h3 class="item_title">Free Shipping</h3>
                                        <p>
                                            Free shipping on all US order
                                        </p>
                                    </div>
                                </div>

                                <div class="policy_item">
                                    <div class="item_icon">
                                        <i class="icon icon-Headset"></i>
                                    </div>
                                    <div class="item_content">
                                        <h3 class="item_title">Support 24/ 7</h3>
                                        <p>
                                            Contact us 24 hours a day
                                        </p>
                                    </div>
                                </div>

                                <div class="policy_item">
                                    <div class="item_icon">
                                        <i class="icon icon-Wallet"></i>
                                    </div>
                                    <div class="item_content">
                                        <h3 class="item_title">100% Money Back</h3>
                                        <p>
                                            You have 30 days to Return
                                        </p>
                                    </div>
                                </div>

                                <div class="policy_item">
                                    <div class="item_icon">
                                        <i class="icon icon-Starship"></i>
                                    </div>
                                    <div class="item_content">
                                        <h3 class="item_title">90 Days Return</h3>
                                        <p>
                                            If goods have problems
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- policy_section - end
            ================================================== -->


            <!-- products-with-sidebar-section - start
            ================================================== -->
            <section class="products-with-sidebar-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 order-lg-3">
                            <div class="best-selling-products">
                                <div class="sec-title-link">
                                    <h3>Latest Products</h3>
                                    <div class="view-all"><a href="{{route('shop')}}">View all<i class="fa fa-long-arrow-right"></i></a></div>
                                </div>
                                <div class="product-area row clearfix">
                                    @foreach ($products as $product)
                                    <div class="grid col-lg-4 my-3">
                                        <div class="product-pic">
                                            <a href="{{route('product.details', $product->id)}}"><img src="{{asset('/uploads/products/preview')}}/{{$product->preview}}" ></a>
                                            @if ($product->discount)
                                                <span class="theme-badge-2">{{$product->discount}}% OFF</span>
                                            @endif
                                            <div class="actions">
                                                <ul>

                                                    <li>
                                                        <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup{{$product->id}}" role="button" tabindex="0"><svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Visible (eye)</title> <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/> <circle cx="12" cy="12" r="3"/> </svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <h4><a href="{{route('product.details', $product->id)}}">{{$product->product_name}}</a></h4>
                                            <p><a href="{{route('product.details', $product->id)}}">{{$product->short_desp}}</a></p>

                                            @php
                                                $sum_star = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->sum('star');

                                                $review_count = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->count();
                                                if($review_count == 0){
                                                    $avg = 0;
                                                }else {
                                                    $avg = round($sum_star / $review_count);
                                                }
                                            @endphp
                                            <div class="rating">
                                                @for ($i=1; $i<=$avg; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                            <span class="price{{$product->id}}">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol">TK </span>{{$product->after_discount}}
                                                        </bdi>
                                                    </span>
                                                </ins>
                                            </span>
                                        <div class="row">
                                            <div class="col-lg-6">
                                            <div class="add-cart-area">
                                                <form action="{{route('wishlist.store')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    @auth('customerlogin')
                                                    <button class="add-to-cart" type="submit">Favourite</button>
                                                </form>
                                                    @else
                                                   <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('customer.register')}}">Favourite</a></button>
                                                    @endauth
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                            <div class="add-cart-area">
                                                   <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('product.details', $product->id)}}">Buy Now</a></button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                 <!-- product quick view modal - start
                                    ================================================== -->
                                    <div class="modal fade" id="quickview_popup{{$product->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalToggleLabel2">Product Quick View</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="product_details">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col col-lg-6">
                                                                    <div class="product_details_image p-0">
                                                                        <img src="{{asset('/uploads/products/preview/')}}/{{$product->preview}}" alt>
                                                                    </div>
                                                                </div>

                                                    <div class="col-lg-6">
                                                        <form action="{{route('cart.store')}}" method="POST">
                                                            @csrf
                                                    <div class="product_details_content">
                                                        <h4>{{$product->product_name}}</h4>
                                                        <p>{{$product->short_desp}}</p>
                                                        <input type="hidden" class="product_id{{$product->id}}" name="product_id" value="{{$product->id}}">
                                                        @php
                                                         $sum_star = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->sum('star');

                                                         $review_count = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->count();
                                                            if($review_count == 0){
                                                                $avg = 0;
                                                            }else {
                                                                $avg = round($sum_star / $review_count);
                                                            }
                                                        @endphp

                                                        <div class="item_review">
                                                            <ul class="rating_star ul_li">
                                                                @for ($i=1; $i<=$avg; $i++)
                                                                    <li><i class="fa fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                            <span class="review_value">{{App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->sum('star');}} Rating(s)</span>
                                                        </div>

                                                        <div class="item_price">
                                                            <span>TK <span id="price{{$product->id}}">{{$product->after_discount}}</span></span>
                                                            <del> {{$product->product_price}}</del>
                                                        </div>
                                                        <hr>

                                                        <div class="item_attribute">
                                                                <div class="row">
                                                                    <div class="col col-md-6">
                                                                        <div class="select_option clearfix">
                                                                            <h4 class="input_title">Color *</h4>
                                                                            <select data-id="{{$product->id}}" class="form-control choose_color" id="color_id" name="color_id">
                                                                                <option value="">Choose A Option</option>
                                                                                @foreach (App\Models\Inventory::where('product_id', $product->id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get() as $color)
                                                                                <option value="{{$color->rel_to_color->id}}">
                                                                                    @php
                                                                                        if(App\Models\Color::where('id', $color->color_id)->exists()){
                                                                                            echo $color->rel_to_color->color_name;
                                                                                        }
                                                                                        else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    @endphp
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col col-md-6">
                                                                        <div class="select_option clearfix">
                                                                            <h4 class="input_title">Size *</h4>
                                                                            <select id="size_id{{$product->id}}" name="size_id" class="form-control size_id">
                                                                                <option class="form-control">Choose a Size</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                            <div class="quantity_wrap">
                                                                <div class="quantity_input">
                                                                    <button type="button" class="input_number_decrement"data-productid="{{$product->id}}">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                    <input class="input_number{{$product->id}}" type="text" value="1" name="quantity">
                                                                    <button type="button" class="input_number_increment" data-productid="{{$product->id}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="total_price">Total: TK <span id="total{{$product->id}}">{{$product->after_discount}}</span></div>
                                                            </div>

                                                            <ul class="default_btns_group ul_li">
                                                                @auth('customerlogin')
                                                                    <li class="stock{{$product->id}}">
                                                                        <button class="btn btn-primary addtocart_btn"   type="submit">Add To Cart</button>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="btn btn_primary addtocart_btn" href="{{route('customer.register')}}">Add To Cart</a>
                                                                    </li>
                                                                @endauth
                                                            </ul>
                                                        </div>
                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product quick view modal - end
                                    ================================================== -->
                                    @endforeach
                                </div>
                            </div>

                            <div class="top_category_wrap">
                                <div class="sec-title-link">
                                    <h3>Top categories</h3>
                                </div>
                                <div class="top_category_carousel2" data-slick='{"dots": false}'>
                                    @foreach ($categories as $category)
                                    <div class="slider_item">
                                        <div class="category_boxed">
                                            <a href="{{url('/shop/'.$category->id)}}">
                                                  <span class="item_image">
                                                      <img src="{{asset('/uploads/category/')}}/{{$category->category_image}}" alt="image_not_found">
                                                  </span>
                                                <span class="item_title">{{$category->category_name}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="carousel_nav carousel-nav-top-right">
                                    <button type="button" class="tc_left_arrow"><i class="fa fa-long-arrow-alt-left"></i></button>
                                    <button type="button" class="tc_right_arrow"><i class="fa fa-long-arrow-alt-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 order-lg-9">
                            <div class="product-sidebar">
                                <div class="widget latest_product_carousel">
                                    <div class="title_wrap">
                                        <h3 class="area_title">Best Selling</h3>
                                        <div class="carousel_nav">
                                            <button type="button" class="vs4i_left_arrow"><i class="fa fa-angle-left"></i></button>
                                            <button type="button" class="vs4i_right_arrow"><i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="vertical_slider_4item" data-slick='{"dots": false}'>
                                        @foreach ($best_selling as $best_sell)
                                            <div class="slider_item">
                                                <div class="small_product_layout">
                                                    <a class="item_image" href="{{route('product.details', $best_sell->product_id)}}">
                                                        <img src="{{asset('/uploads/products/preview')}}/{{$best_sell->rel_to_product->preview}}" alt="image_not_found">
                                                    </a>
                                                    <div class="item_content">
                                                        <h3 class="item_title">
                                                            <a href="{{route('product.details', $best_sell->product_id)}}">{{$best_sell->rel_to_product->product_name}}</a>
                                                        </h3>
                                                        @php
                                                         $sum_star = App\Models\Orderproduct::where('product_id', $best_sell->product_id)->whereNotNull('review')->sum('star');

                                                         $review_count = App\Models\Orderproduct::where('product_id', $best_sell->product_id)->whereNotNull('review')->count();
                                                            if($review_count == 0){
                                                                $avg = 0;
                                                            }else {
                                                                $avg = round($sum_star / $review_count);
                                                            }
                                                        @endphp

                                                        <ul class="rating_star ul_li">
                                                            @for ($i=1; $i<=$avg; $i++)
                                                                    <li><i class="fa fa-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                        <div class="item_price">
                                                            <span>{{$best_sell->rel_to_product->after_discount}}</span>
                                                            <del>{{$best_sell->rel_to_product->product_price}}</del>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="widget product-add">
                                    <div class="product-img">
                                        <img src="{{asset('front/images/shop/product_img_10.png')}}" alt>
                                    </div>
                                    <div class="details">
                                        <h4>iPad pro</h4>
                                        <p>iPad pro with M1 chipe</p>
                                        <a class="btn btn_primary" href="#" >Start Buying</a>
                                    </div>
                                </div>
                                <div class="widget audio-widget">
                                    <h5>Audio <span>5</span></h5>
                                    <ul>
                                        <li><a href="#">MI headphone</a></li>
                                        <li><a href="#">Bluetooth AirPods</a></li>
                                        <li><a href="#">Music system</a></li>
                                        <li><a href="#">JBL bar 5.1</a></li>
                                        <li><a href="#">Edifier Computer Speaker</a></li>
                                        <li><a href="#">Macbook pro</a></li>
                                        <li><a href="#">Men's watch</a></li>
                                        <li><a href="#">Washing metchin</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end container  -->
            </section>
            <!-- products-with-sidebar-section - end
            ================================================== -->


            <!-- promotion_section - start
            ================================================== -->
            <section class="promotion_section">
                <div class="container">
                    <div class="row promotion_banner_wrap">
                        <div class="col col-lg-6">
                            <div class="promotion_banner">
                                <div class="item_image">
                                    <img src="{{asset('front/images/promotion/banner_img_1.png')}}" alt>
                                </div>
                                <div class="item_content">
                                    <h3 class="item_title">Protective sleeves <span>combo.</span></h3>
                                    <p>It is a long established fact that a reader will be distracted</p>
                                    <a class="btn btn_primary" href="shop_details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-6">
                            <div class="promotion_banner">
                                <div class="item_image">
                                    <img src="{{asset('front/images/promotion/banner_img_2.png')}}" alt>
                                </div>
                                <div class="item_content">
                                    <h3 class="item_title">Nutrillet blender <span>combo.</span></h3>
                                    <p>
                                        It is a long established fact that a reader will be distracted
                                    </p>
                                    <a class="btn btn_primary" href="shop_details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- promotion_section - end
            ================================================== -->

            <!-- new_arrivals_section - start
            ================================================== -->
            <section class="new_arrivals_section section_space">
                <div class="container">
                    <div class="sec-title-link">
                        <h3>New Arrivals</h3>
                    </div>

                    <div class="row newarrivals_products">
                        <div class="col col-lg-5">
                            <div class="deals_product_layout1">
                                <div class="bg_area">
                                    <h3 class="item_title">Best <span>Product</span> Deals</h3>
                                    <p>
                                        Get a 20% Cashback when buying TWS Product From SoundPro Audio Technology.
                                    </p>
                                    <a class="btn btn_primary" href="shop_details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="col col-lg-7">
                            <div class="new-arrivals-grids clearfix">
                                @foreach ($new_arival as $new)
                                <div class="grid">
                                    <div class="product-pic">
                                        <a href="{{route('product.details', $new->id)}}"><img src="{{asset('/uploads/products/preview')}}/{{$new->preview}}" alt></a>
                                        <div class="actions">
                                            <ul>

                                                <li>
                                                    <a class="quickview_btn" data-bs-toggle="modal" href="#new{{$new->id}}"><svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Visible (eye)</title> <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/> <circle cx="12" cy="12" r="3"/> </svg></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <h4><a href="{{route('product.details', $new->id)}}">{{$new->product_name}}</a></h4>
                                        <p><a href="{{route('product.details', $new->id)}}">{{$new->short_desp}}</a></p>
                                    @php
                                        $sum_star = App\Models\Orderproduct::where('product_id', $new->id)->whereNotNull('review')->sum('star');

                                        $review_count = App\Models\Orderproduct::where('product_id', $new->id)->whereNotNull('review')->count();
                                        if($review_count == 0){
                                            $avg = 0;
                                        }else {
                                            $avg = round($sum_star / $review_count);
                                        }
                                    @endphp
                                    <div class="rating">
                                        @for ($i=1; $i<=$avg; $i++)
                                        <i class="fa fa-star"></i>
                                        @endfor
                                    </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi>
                                                        <span class="woocommerce-Price-currencySymbol">TK </span>{{$new->after_discount}}
                                                    </bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="row">
                                            <div class="col-lg-6">
                                            <div class="add-cart-area">
                                                <form action="{{route('wishlist.store')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$new->id}}">
                                                    @auth('customerlogin')
                                                    <button class="add-to-cart" type="submit">Favourite</button>
                                                </form>
                                                    @else
                                                   <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('customer.register')}}">Favourite</a></button>
                                                    @endauth
                                            </div>
                                            </div>

                                            <div class="col-lg-6">
                                            <div class="add-cart-area">
                                                   <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('product.details', $new->id)}}">Buy Now</a></button>

                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                 <!-- product quick view modal - start
                                    ================================================== -->
                                    <div class="modal fade" id="new{{$new->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalToggleLabel2">Product Quick View</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="product_details">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col col-lg-6">
                                                                    <div class="product_details_image p-0">
                                                                        <img src="{{asset('/uploads/products/preview/')}}/{{$new->preview}}" alt>
                                                                    </div>
                                                                </div>

                                                <div class="col-lg-6">
                                                    <form action="{{route('cart.store')}}" method="POST">
                                                        @csrf
                                                    <div class="product_details_content">
                                                        <h4>{{$new->product_name}}</h4>
                                                        <p>{{$new->short_desp}}</p>
                                                        <input type="hidden" name="product_id" value="{{$new->id}}">
                                                        @php
                                                            $sum_star = App\Models\Orderproduct::where('product_id', $new->id)->whereNotNull('review')->sum('star');

                                                            $review_count = App\Models\Orderproduct::where('product_id', $new->id)->whereNotNull('review')->count();
                                                            if($review_count == 0){
                                                                $avg = 0;
                                                            }else {
                                                                $avg = round($sum_star / $review_count);
                                                            }
                                                       @endphp
                                                        <div class="item_review">
                                                            <ul class="rating_star ul_li">
                                                                @for ($i=1; $i<=$avg; $i++)
                                                                    <li><i class="fa fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                            <span class="review_value">{{App\Models\Orderproduct::where('product_id', $new->id)->whereNotNull('review')->sum('star');}} Rating(s)</span>
                                                        </div>

                                                        <div class="item_price">
                                                            <span>TK <span id="pricenew{{$new->id}}">{{$new->after_discount}}</span></span>
                                                            <del> {{$new->product_price}}</del>
                                                        </div>
                                                        <hr>

                                                        <div class="item_attribute">
                                                                <div class="row">
                                                                    <div class="col col-md-6">
                                                                        <div class="select_option clearfix">
                                                                            <h4 class="input_title">Color *</h4>
                                                                            <select data-ids="{{$new->id}}" class="form-control choose_colors" id="color_id" name="color_id">
                                                                                <option value="">Choose A Option</option>
                                                                                @foreach (App\Models\Inventory::where('product_id', $new->id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get() as $color)
                                                                                <option value="{{$color->rel_to_color->id}}">
                                                                                    @php
                                                                                        if(App\Models\Color::where('id', $color->color_id)->exists()){
                                                                                            echo $color->rel_to_color->color_name;
                                                                                        }
                                                                                        else{
                                                                                            echo 'N/A';
                                                                                        }
                                                                                    @endphp
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col col-md-6">
                                                                        <div class="select_option clearfix">
                                                                            <h4 class="input_title">Size *</h4>
                                                                            <select  class="form-control size_ids" name="size_id" id="size_ids{{$new->id}}">
                                                                                <option class="form-control">Choose a Size</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                            <div class="quantity_wrap">
                                                                <div class="quantity_input">
                                                                    <button type="button" class="input_number_decrementnew" data-productidnew="{{$new->id}}">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                    <input class="input_numbernew{{$new->id}}" type="text" value="1"  name="quantity">
                                                                    <button type="button" class="input_number_incrementnew" data-productidnew="{{$new->id}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="total_price">Total: TK <span id="totalnew{{$new->id}}">{{$new->after_discount}}</span></div>
                                                            </div>

                                                            <ul class="default_btns_group ul_li">
                                                                @auth('customerlogin')
                                                                    <li class="stocks{{$new->id}}">
                                                                        <button class="btn btn-primary addtocart_btn"   type="submit">Add To Cart</button>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="btn btn_primary addtocart_btn" href="{{route('customer.register')}}">Add To Cart</a>
                                                                    </li>
                                                                @endauth
                                                            </ul>
                                                        </div>
                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product quick view modal - end
                                    ================================================== -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- new_arrivals_section - end
            ================================================== -->

            <!-- brand_section - start
            ================================================== -->
            <div class="brand_section pb-0">
                <div class="container">
                    <div class="brand_carousel">
                        @foreach ($brands as $brand)
                        <div class="slider_item">
                            <a class="product_brand_logo brand_name" href="#" data-brand="{{$brand->brand_name}}">
                                <img src="{{asset('/uploads/brand')}}/{{$brand->brand_image}}" alt="image_not_found">
                                <img src="{{asset('/uploads/brand')}}/{{$brand->brand_image}}" alt="image_not_found">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- brand_section - end
            ================================================== -->

            <!-- viewed_products_section - start
================================================== -->
<section class="viewed_products_section section_space">
    <div class="container">
        <div class="sec-title-link mb-0">
            <h3>Recently Viewed Products</h3>
        </div>

        <div class="viewed_products_wrap arrows_topright">
            <div class="viewed_products_carousel row">
                <@foreach ($recent_product as $recent_viewed)
                <div class="slider_item col">
                    <div class="viewed_product_item">
                        <div class="item_image">
                                <a href="{{route('product.details', $recent_viewed->id)}}"><img src="{{asset('/uploads/products/preview')}}/{{$recent_viewed->preview}}" alt="image_not_found"></a>
                        </div>
                        <div class="item_content">
                                <a href="{{route('product.details', $recent_viewed->id)}}"><h4 class="item_title">{{$recent_viewed->product_name}}</h4></a>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="carousel_nav">
                <button type="button" class="vpc_left_arrow"><i class="fa fa-long-arrow-left"></i></button>
                <button type="button" class="vpc_right_arrow"><i class="fa fa-long-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>
<!-- viewed_products_section - end
================================================== -->
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "102903278488225");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v14.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

@endsection


@section('footer_script')
<script>
    // var databrand = $('.brand_name').attr('data-brand');

    $('.brand_name').click(function (){
        var search_input = $('#search_input').val();
        var brand_name =  $(this).attr('data-brand');
        var category_id = $('input[class="category_id"]:checked').val();
        var subcategory_id = $('input[class="subcategory_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var price_range = $('#price_range').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&brand_name="+brand_name+"&category_id="+category_id+"&subcategory_id="+subcategory_id+"&color_id="+color_id+"&size_id="+size_id+"&price_range="+price_range;
        window.location.href = link;
    });
    </script>

    <script>
    //total price calculate ++ for letest product model
    $('.input_number_increment').click(function(){
        var product_id = $(this).attr('data-productid');
        var quantity = $('.input_number'+product_id).val();
        quantity++
        $('.input_number'+product_id).val(quantity);
        var price = $('#price'+product_id).html();
        var total = price*quantity;
        $('#total'+product_id).html(total);
    });

    $('.input_number_decrement').click(function(){
        var product_id = $(this).attr('data-productid');
        var quantity = $('.input_number'+product_id).val();
        if(quantity > 1){
            quantity--
        }
        $('.input_number'+product_id).val(quantity);
        var price = $('#price'+product_id).html();
        var total = price*quantity;
        $('#total'+product_id).html(total);
    });

    //total price calculate ++ for new product model
    $('.input_number_decrementnew').click(function(){
        var product_idnew = $(this).attr('data-productidnew');
        var quantitynew = $('.input_numbernew'+product_idnew).val();
        if(quantitynew > 1){
            quantitynew--
        }
        $('.input_numbernew'+product_idnew).val(quantitynew);
        var pricenew = $('#pricenew'+product_idnew).html();
        var totalnew = pricenew*quantitynew;
        $('#totalnew'+product_idnew).html(totalnew);
    });

    $('.input_number_incrementnew').click(function(){
        var product_idnew = $(this).attr('data-productidnew');
        var quantitynew = $('.input_numbernew'+product_idnew).val();
        quantitynew++
        $('.input_numbernew'+product_idnew).val(quantitynew);
        var pricenew = $('#pricenew'+product_idnew).html();
        var totalnew = pricenew*quantitynew;
        $('#totalnew'+product_idnew).html(totalnew);
    });
</script>


<script>
    // get size letest
    $('.choose_color').change(function(){
            var color_id = $(this).val();
            var product_id = $(this).attr('data-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getSize',
                data:{'color_id':color_id, 'product_id':product_id},
                success:function(data){
                    $('#size_id'+product_id).html(data);
                }
            });
        })
</script>

<script>
    // get size new arrival
    $('.choose_colors').change(function(){
            var color_id = $(this).val();
            var product_id = $(this).attr('data-ids');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getSizes',
                data:{'color_id':color_id, 'product_id':product_id},
                success:function(data){
                    $('#size_ids'+product_id).html(data);
                }
            });
        })
</script>

{{-- get size color id for add to cart ajax for letest--}}
<script>
    $('.size_id').change(function(){
            var size_id = $(this).val();
            var color_id =  $(this).find('option:selected').attr('id');
            var product_id =  $(this).find('option:selected').attr('class');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/stock',
                data:{'color_id':color_id, 'product_id':product_id, 'size_id':size_id},
                success:function(data){
                    $('.stock'+product_id).html(data);
                }
            });
        });
    </script>


{{-- get size color id for add to cart ajax for new arrival--}}
<script>
    $('.size_ids').change(function(){
            var size_id = $(this).val();
            var color_id =  $(this).find('option:selected').attr('id');
            var product_id =  $(this).find('option:selected').attr('class');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/stocks',
                data:{'color_id':color_id, 'product_id':product_id, 'size_id':size_id},
                success:function(data){
                    $('.stocks'+product_id).html(data);
                }
            });
        });
    </script>
@endsection
