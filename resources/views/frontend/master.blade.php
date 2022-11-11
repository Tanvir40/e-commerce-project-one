<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="@foreach(App\Models\MetaTag::get() as $tags){{$tags->tag_name}} @endforeach">
    <meta name="author" content="Tanvir Hasan Tonmoy">
    <meta name="publisher" content="Tanvir Hasan Tonmoy">

   <title>Tanvir - E-Commerce Demo project</title>
   <meta name="description" content="Tanvir - E-commerce Demo project" />

    <link rel="shortcut icon" href="{{asset('front/images/logo/favourite_icon_1.png')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- fraimwork - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/bootstrap.min.css')}}">

   <!-- icon font - css include -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/stroke-gap-icons.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/icofont.css')}}">

   <!-- animation - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/animate.css')}}">

   <!-- carousel - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/slick.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/slick-theme.css')}}">

   <!-- popup - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/magnific-popup.css')}}">

   <!-- jquery-ui - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/jquery-ui.css')}}">

   <!-- select option - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/nice-select.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/woocommerce-2.css')}}">
   <!-- custom - css include -->
   <link rel="stylesheet" type="text/css" href="{{asset('front/css/style.css')}}">

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>

<body>
                <!-- sidebar cart - start
            ================================================== -->
            <div class="sidebar-menu-wrapper">
                <div class="cart_sidebar">
                    <button type="button" class="close_btn"><i class="fa fa-times"></i></button>
                    <ul class="cart_items_list ul_li_blocdk mb_30 clearfix">
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach(App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->get() as $cart)
                        <li>
                            <div class="item_image">
                                <img src="{{asset('/uploads/products/preview')}}/{{$cart->rel_to_product->preview}}" alt="image_not_found">
                            </div>
                            <div class="item_content">
                                <h4 class="item_title">{{$cart->rel_to_product->product_name}}</h4>
                                <span class="item_price">Tk: {{$cart->rel_to_product->after_discount}} X {{$cart->quantity}}</span>
                            </div>
                            <a href="{{route('cart.remove', $cart->id)}}" class="remove_btn"><i class="fa fa-trash"></i></a>
                        </li>
                        @php
                            $subtotal += $cart->rel_to_product->after_discount*$cart->quantity;
                        @endphp
                        @endforeach
                    </ul>
                    <ul class="total_price ul_li_block mb_30 clearfix">
                        <li>
                            <span>Subtotal:</span>
                            <span>{{$subtotal}}</span>
                        </li>
                    </ul>

                    <ul class="btns_group ul_li_block clearfix">
                        <li><a class="btn btn_primary" href="{{route('cart.view')}}">View Cart</a></li>
                    </ul>
                </div>

                <div class="cart_overlay"></div>
            </div>
            <!-- sidebar cart - end
            ================================================== -->


    <!-- body_wrap - start -->
    <div class="body_wrap">

        <!-- backtotop - start -->
        <div class="backtotop">
            <a href="#" class="scroll">
                <i class="fa fa-arrow-up"></i>
            </a>
        </div>
        <!-- backtotop - end -->

        <!-- preloader - start -->
        <div id="preloader"></div>
        <!-- preloader - end -->


        <!-- header_section - start
        ================================================== -->
        <header class="header_section {{(Route::CurrentRouteName() == 'index'?'header-style-no-collapse':'header-style-3')}}">
            <div class="header_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-md-6">
                            <ul class="header_select_options ul_li">
                                <li>
                                    <div class="select_option">
                                        <div class="flug_wrap">
                                            <img src="{{asset('front/images/flug/flug_uk.png')}}" alt="image_not_found">
                                        </div>
                                        <select class="selectstyle">
                                            <option data-display="Select Option">Select Your Language</option>
                                            <option value="1" selected>English</option>
                                            <option value="2">Bangla</option>
                                            <option value="3" disabled>Arabic</option>
                                            <option value="4">Hebrew</option>
                                        </select>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="col col-md-6">
                            <p class="header_hotline">Call us toll free: <strong>+1888 234 5678</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-lg-3 col-md-3 col-sm-3">
                            <div class="brand_logo">
                                <a class="brand_link" href="{{route('index')}}">
                                    <img width="150px" src="{{asset('front/images/logo/logo_1x.png')}}" srcset="{{asset('front/images/logo/logo_1x.png')}} 2x" alt>
                                </a>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12">
                                <div class="advance_serach">
                                    <div class="select_option mb-0 clearfix">
                                        <select class="selectstyle">
                                            <option data-display="All Categories">Select A Category</option>
                                            @foreach (App\Models\Category::all() as $category)
                                                <option value="{{$category->id}}"
                                                @isset($_GET['category_id'])
                                                @if ($_GET['category_id'] == $category->id)
                                                    selected
                                                @endif
                                            @endisset
                                                >{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form_item">
                                        <input type="search" id="search_input" name="search" value="{{@$_GET['q']}}" placeholder="Search Prudcts...">
                                        <button type="submit" id="search_btn" class="search_btn"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-12">
                            <button class="mobile_menu_btn2 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_menu_dropdown" aria-controls="main_menu_dropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>
                            <button type="button" class="cart_btn">


                                        <a href="{{route('wishlist')}}">
                                            <svg role="img" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" stroke="#051d43" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Favourite</title> <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>
                                            <span class="wishlist_counter rounded-pill bg-warning">{{App\Models\Wishlist::where('customer_id', Auth::guard('customerlogin')->id())->count()}}</span>
                                        </a>


                                        <span class="cart_icon">
                                            <i class="icon icon-ShoppingCart"></i>
                                            <small class="cart_counter">{{App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count()}}</small>
                                        </span>


                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header_bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-3 col-md-3">
                            <div class="allcategories_dropdown">
                                <button class="allcategories_btn" type="button" data-bs-toggle="collapse" data-bs-target="#allcategories_collapse" aria-expanded="false" aria-controls="allcategories_collapse">
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24" aria-labelledby="statsIconTitle" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000"> <title id="statsIconTitle">Stats</title> <path d="M6 7L15 7M6 12L18 12M6 17L12 17"/> </svg>
                                    Browse categories
                                </button>
                                <div class="allcategories_collapse {{(Route::CurrentRouteName() == 'index'?'':'collapse')}}" id="allcategories_collapse">
                                    <div class="card card-body">
                                        <ul class="allcategories_list ul_li_block">
                                            @foreach (App\Models\Category::all() as $category)
                                            <li><a href="{{url('/shop/'.$category->id)}}"><i class="icon icon-Starship"></i> {{$category->category_name}} ({{App\Models\Product::where('category_id', $category->id)->count()}})</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <nav class="main_menu navbar navbar-expand-lg">
                                <div class="main_menu_inner collapse navbar-collapse" id="main_menu_dropdown">
                                    <button type="button" class="offcanvas_close">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <ul class="main_menu_list ul_li">
                                        <li><a class="nav-link" href="{{route('index')}}">Home</a></li>
                                        <li><a class="nav-link" href="{{route('shop')}}">Shop</a></li>
                                        <li><a class="nav-link" href="{{route('about.us')}}">About us</a></li>
                                        <li><a class="nav-link" href="{{route('contact.us')}}">Contact Us</a></li>
                                        <li><a class="nav-link" href="{{route('privacy.policy')}}">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="offcanvas_overlay"></div>
                        </div>

                        <div class="col col-md-3">
                            <ul class="header_icons_group ul_li_right">
                                 <li>
                                     @auth('customerlogin')
                                     <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{Auth::guard('customerlogin')->user()->name}}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                          <li><a class="dropdown-item" href="{{route('customer.account')}}">My Account</a></li>
                                          <li><a class="dropdown-item" href="{{route('customer.logout')}}">Logout</a></li>
                                        </ul>
                                      </div>
                                     @else
                                     <a href="{{route('customer.register')}}">Login/Register</a>
                                     @endauth
                                </li>
                                <li>
                                    <a href="">
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" stroke="#051d43" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title id="personIconTitle">Person</title> <path d="M4,20 C4,17 8,17 10,15 C11,14 8,14 8,9 C8,5.667 9.333,4 12,4 C14.667,4 16,5.667 16,9 C16,14 13,14 14,15 C16,17 20,17 20,20"/> </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header_section - end
        ================================================== -->


        <!-- main body - start
        ================================================== -->
        <main>

@yield('content')

        </main>
        <!-- main body - end
        ================================================== -->



         <!-- newsletter_section - start
            ================================================== -->
            <section class="newsletter_section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-lg-6">
                            <h2 class="newsletter_title text-white">Sign Up for Newsletter </h2>
                            <p>Get E-mail updates about our latest products and special offers.</p>
                        </div>
                        <div class="col col-lg-6">
                            <form action="{{route('insert.email')}}" method="POST">
                                @csrf
                                    @if (session('added_success'))
                                        <div class="alert alert-success">{{session('added_success')}}</div>
                                    @endif
                                <div class="newsletter_form">
                                    @error('customer_email')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                    <input type="email" name="customer_email" class="form-control" placeholder="Enter your email address">
                                    <button type="submit" class="btn btn_secondary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- newsletter_section - end
            ================================================== -->
            <div class="sidecall">
                <a href="tel:+88 01821732936" target="_blank" class="phoneicon_sm"><i class="fa fa-phone"></i></a>
                <a class="whtsapp_sm" href="https://wa.me/8801821732936" target="_blank"><i class="fa fa-whatsapp"></i></a>
            </div>

            <div id="footfix">
                <a href="tel:+88 01821732936" target="_blank" class="phoneicon_sm"><i class="fa fa-phone"></i></a>
                <a class="whtsapp_sm" href="https://wa.me/8801821732936" target="_blank"><i class="fa fa-whatsapp"></i></a>
            </div>
                
        <!-- footer_section - start
        ================================================== -->
        <footer class="footer_section">
            <div class="footer_widget_area">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-4 col-md-6 col-sm-6">
                            <div class="footer_widget footer_about">
                                <div class="brand_logo">
                                    <a class="brand_link" href="{{route('index')}}">
                                        <img width="150px" src="{{asset('front/images/logo/logo_1x.png')}}" srcset="{{asset('front/images/logo/logo_1x.png')}} 2x" alt="logo_not_found">
                                    </a>
                                </div>
                                <ul class="social_round ul_li">
                                    @foreach (App\Models\social::get() as $social)
                                    <li><a href="{{$social->page_link}}"><i class="{{$social->social_icon}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-2 col-md-3 col-sm-6">
                            <div class="footer_widget footer_useful_links">
                                <h3 class="footer_widget_title text-uppercase">Quick Links</h3>
                                <ul class="ul_li_block">
                                    <li><a href="{{route('about.us')}}">About Us</a></li>
                                    <li><a href="{{route('contact.us')}}">Contact Us</a></li>
                                    <li><a href="shop.html">Products</a></li>
                                    <li><a href="{{route('customer.register')}}">Login</a></li>
                                    <li><a href="{{route('customer.register')}}">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-2 col-md-3 col-sm-6">
                            <div class="footer_widget footer_useful_links">
                                <h3 class="footer_widget_title text-uppercase">Custom area</h3>
                                <ul class="ul_li_block">
                                    @auth('customerlogin')
                                    <li><a href="{{route('customer.account')}}">My Account</a></li>
                                    @else
                                    <li><a href="{{route('customer.register')}}">My Account</a></li>
                                    @endauth
                                    <li><a href="{{route('customer.account')}}">Orders</a></li>
                                    <li><a href="#!">Team</a></li>
                                    <li><a href="{{route('privacy.policy')}}">Privacy Policy</a></li>
                                    <li><a href="{{route('cart.view')}}">My Cart</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col col-lg-4 col-md-6 col-sm-6">
                            <div class="footer_widget footer_contact">
                                <h3 class="footer_widget_title text-uppercase">Contact Onfo</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
                                </p>
                                <div class="hotline_wrap">
                                    <div class="footer_hotline">
                                        <div class="item_icon">
                                            <i class="icofont-headphone-alt"></i>
                                        </div>
                                        <div class="item_content">
                                            <h4 class="item_title">Have any question?</h4>
                                            <span class="hotline_number">+ 123 456 7890</span>
                                        </div>
                                    </div>
                                    {{-- <div class="livechat_btn clearfix">
                                        <a class="btn border_primary" href="#!">Live Chat</a>
                                    </div> --}}
                                </div>
                                <ul class="store_btns_group ul_li">
                                    <li><a href="#!"><img src="{{asset('front/images/app_store.png')}}" alt="app_store"></a></li>
                                    <li><a href="#!"><img src="{{asset('front/images/play_store.png')}}" alt="play_store"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer_bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col col-md-6">
                            <p class="copyright_text">
                                ©2021 <a href="#!">your name</a>. All Rights Reserved.
                            </p>
                        </div>

                        <div class="col col-md-6">
                            <div class="payment_method">
                                <h4>Payment:</h4>
                                <img src="{{asset('front/images/payments_icon.png')}}" alt="image_not_found">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer_section - end
        ================================================== -->

    </div>
    <!-- body_wrap - end -->

    <!-- fraimwork - jquery include -->
    <script src="{{asset('front/js/jquery.min.js')}}"></script>
    <script src="{{asset('front/js/popper.min.js')}}"></script>
    <script src="{{asset('front/js/bootstrap.min.js')}}"></script>

    <!-- carousel - jquery plugins collection -->
    <script src="{{asset('front/js/jquery-plugins-collection.js')}}"></script>


    <!-- google map  -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk2HrmqE4sWSei0XdKGbOMOHN3Mm2Bf-M&ver=2.1.6"></script>
    <script src="{{asset('front/js/gmaps.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- custom - main-js -->
    <script src="{{asset('front/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    @yield('footer_script')
    <script>
        $('#search_btn').click(function (){
            var search_input = $('#search_input').val();
            var category_id = $('#category_id :selected').val();
            var subcategory_id = $('#subcategory_id :selected').val();
            var color_id = $('#color_id :selected').val();
            var size_id = $('#size_id :selected').val();
            var amount = $('#price-range').val();
            var link = "{{route('shop')}}"+"?q="+search_input+"&category_id="+category_id+"&subcategory_id="+subcategory_id+"&color_id="+color_id+"&size_id="+size_id+"&amount="+amount;
            window.location.href = link;
        });
    </script>
</body>
</html>

