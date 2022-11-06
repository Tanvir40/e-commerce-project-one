@extends('frontend.master')
@section('content')
   <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Product Grid</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->





<!-- product_section - start
================================================== -->
<section class="product_section section_space">
    <h2 class="hidden">Product sidebar</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <aside class="sidebar_section p-0 mt-0">
                    <div class="sb_widget">

                        <div class="filter_sidebar">
                            <div class="fs_widget">
                                <span class="float-end nav-item"><a class="text-dark" href="{{route('shop')}}">Clear Filters</a></span>
                                <h3 class="fs_widget_title">Filter By Brand</h3>
                                <form action="#">
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($brands as $brand)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="apple_brand" class="brand_name" value="{{$brand->brand_name}}" type="radio" name="brand_checkbox"
                                                    @isset($_GET['brand_name'])
                                                        @if ($_GET['brand_name'] == $brand->brand_name)
                                                            checked
                                                        @endif
                                                    @endisset
                                                >
                                                <label for="">{{$brand->brand_name}}<span> ({{App\Models\Product::where('brand_name', $brand->brand_name)->count()}})</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>

                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Filter By Category</h3>
                                <form action="#">
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($categorys as $category)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="apple_brand" class="category_id" value="{{$category->id}}" type="radio" name="brand_checkbox"
                                                    @isset($_GET['category_id'])
                                                        @if ($_GET['category_id'] == $category->id)
                                                            checked
                                                        @endif
                                                    @endisset
                                                >
                                                <label for="">{{$category->category_name}}<span> ({{App\Models\Product::where('category_id', $category->id)->count()}})</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>

                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Filter By Sub-Category</h3>
                                <form action="#">
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($subcategorys as $subcategory)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="apple_brand" class="subcategory_id" value="{{$subcategory->id}}" type="radio" name="brand_checkbox"
                                                    @isset($_GET['subcategory_id'])
                                                        @if ($_GET['subcategory_id'] == $subcategory->id)
                                                            checked
                                                        @endif
                                                    @endisset
                                                >
                                                <label for="">{{$subcategory->subcategory_name}}<span> ({{App\Models\Product::where('subcategory_id', $subcategory->id)->count()}})</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Filter By Color</h3>
                                <form action="#">
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($colors as $color)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="apple_brand" class="color_id" value="{{$color->id}}" type="radio" name="brand_checkbox"
                                                @isset($_GET['color_id'])
                                                    @if ($_GET['color_id'] == $color->id)
                                                        checked
                                                    @endif
                                                @endisset
                                                >
                                                <label for="">{{$color->color_name}}<span> ({{App\Models\Inventory::where('color_id', $color->id)->count()}})</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Filter By Size</h3>
                                <form action="#">
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($sizes as $size)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="apple_brand" class="size_id" value="{{$size->id}}" type="radio" name="brand_checkbox"
                                                @isset($_GET['size_id'])
                                                    @if ($_GET['size_id'] == $size->id)
                                                        checked
                                                    @endif
                                                @endisset
                                                >
                                                <label for="">{{$size->size}}<span> ({{App\Models\Inventory::where('size_id', $size->id)->count()}})</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Filter by Price</h3>
                                <div id="slider-range"></div>
                                <label for="amount">Price range:</label>
                                <input type="text" id="price_range" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            </div>

                        </div>



                    </div>
                </aside>
            </div>

            <div class="col-lg-9">
                <div class="filter_topbar">
                    <div class="row align-items-center">
                        <div class="col col-md-4">
                            <ul class="layout_btns nav" role="tablist">
                                <li>
                                    <button class="active" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-bars"></i></button>
                                </li>
                                <li>
                                    <button data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        <i class="fa fa-th-large"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="col col-md-4">
                            <form action="#">
                                <div class="select_option clearfix">
                                    <select id="sort">
                                        <option value="">Select Your Option</option>

                                        <option value="1"
                                        @isset($_GET['sort'])
                                            @if ($_GET['sort'] == 1)
                                                selected
                                            @endif
                                        @endisset
                                        >Sort By Name(A-Z)</option>

                                        <option value="2"
                                        @isset($_GET['sort'])
                                            @if ($_GET['sort'] == 2)
                                                selected
                                            @endif
                                        @endisset
                                        >Sort By Name(Z-A)</option>

                                        <option value="3"
                                        @isset($_GET['sort'])
                                            @if ($_GET['sort'] == 3)
                                                selected
                                            @endif
                                        @endisset
                                        >Sort By Price(High-Low)</option>

                                        <option value="4"
                                        @isset($_GET['sort'])
                                            @if ($_GET['sort'] == 4)
                                                selected
                                            @endif
                                        @endisset
                                        >Sort By Price(Low-High)</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="col col-md-4">
                            <div class="result_text">Showing {{$products->firstitem()}}-{{$products->lastitem()}} of {{$products->total()}} relults</div>
                        </div>
                    </div>
                </div>

                <hr />

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="home" role="tabpanel">
                                    <div class="shop-product-area shop-product-area-col">
                                        <div class="product-area shop-grid-product-area clearfix">
                                            @forelse ($products as $product)
                                            <div class="grid">
                                                <div class="product-pic">
                                                    <a href="{{route('product.details', $product->id)}}"><img src="{{asset('/uploads/products/preview')}}/{{$product->preview}}" alt></a>
                                                    @if ($product->discount)
                                                    <span class="theme-badge-2">{{$product->discount}}% OFF</span>
                                                    @endif
                                                    <div class="actions">
                                                        <ul>
                                                            <li>
                                                                <a href="#">
                                                                    <svg
                                                                        role="img"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Favourite</title>
                                                                        <path
                                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"
                                                                        />
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <svg
                                                                        role="img"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Shuffle</title>
                                                                        <path d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7" />
                                                                        <path d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17" />
                                                                        <path d="M19 4L22 7L19 10" />
                                                                        <path d="M19 13L22 16L19 19" />
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popupone{{$product->id}}" role="button" tabindex="0">
                                                                    <svg
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Visible (eye)</title>
                                                                        <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z" />
                                                                        <circle cx="12" cy="12" r="3" />
                                                                    </svg>
                                                                </a>
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
                                                    <span class="price">
                                                        <ins>
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi> <span class="woocommerce-Price-currencySymbol">TK: </span>{{$product->after_discount}}</bdi>
                                                            </span>
                                                        </ins>
                                                        <del aria-hidden="true">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi> <span class="woocommerce-Price-currencySymbol">TK: </span>{{$product->product_price}}</bdi>
                                                            </span>
                                                        </del>
                                                    </span>
                                                    <div class="add-cart-area">
                                                        <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('product.details', $product->id)}}">Buy Now</a></button>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- product quick view modal - start
                                    ================================================== -->
                                    <div class="modal fade" id="quickview_popupone{{$product->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
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
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
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
                                                                            <select id="size_id{{$product->id}}" name="size_id" class="form-control sizes_id">
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
                                            @empty
                                            <div class="ps-5">
                                                <h3>No Search Product Found</h3>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="pagination_wrap">
                                        <ul class="pagination_nav">
                                            {{$products->links()}}
                                        </ul>
                                    </div>

                                </div>



                                {{-- grid shop item product start --}}
                                <div class="tab-pane fade" id="profile" role="tabpanel">
                                    <div class="product_layout2_wrap">
                                        <div class="product-area-row">
                                            @forelse ($products as $product)
                                            <div class="grid clearfix">
                                                <div class="product-pic">
                                                    <a href="{{route('product.details', $product->id)}}"><img src="{{asset('/uploads/products/preview')}}/{{$product->preview}}" alt></a>
                                                    @if ($product->discount)
                                                    <span class="theme-badge-2">{{$product->discount}}% OFF</span>
                                                    @endif
                                                    <div class="actions">
                                                        <ul>
                                                            <li>
                                                                <a href="#">
                                                                    <svg
                                                                        role="img"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Favourite</title>
                                                                        <path
                                                                            d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"
                                                                        />
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <svg
                                                                        role="img"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Shuffle</title>
                                                                        <path d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7" />
                                                                        <path d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17" />
                                                                        <path d="M19 4L22 7L19 10" />
                                                                        <path d="M19 13L22 16L19 19" />
                                                                    </svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popuptwo{{$product->id}}" role="button" tabindex="0">
                                                                    <svg
                                                                        width="48px"
                                                                        height="48px"
                                                                        viewBox="0 0 24 24"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        stroke="#2329D6"
                                                                        stroke-width="1"
                                                                        stroke-linecap="square"
                                                                        stroke-linejoin="miter"
                                                                        fill="none"
                                                                        color="#2329D6"
                                                                    >
                                                                        <title>Visible (eye)</title>
                                                                        <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z" />
                                                                        <circle cx="12" cy="12" r="3" />
                                                                    </svg>
                                                                </a>
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
                                                    <span class="price">
                                                        <ins>
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi> <span class="woocommerce-Price-currencySymbol">TK: </span>{{$product->after_discount}}</bdi>
                                                            </span>
                                                        </ins>
                                                    </span>
                                                    <div class="add-cart-area">
                                                        <button class="add-to-cart" type="submit"><a class="text-dark" href="{{route('product.details', $product->id)}}">Buy Now</a></button>
                                                    </div>
                                                </div>
                                            </div>
            <!-- product quick view modal - start
                                    ================================================== -->
                                    <div class="modal fade" id="quickview_popuptwo{{$product->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
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
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
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
                                                            <span>TK <span id="pricenew{{$product->id}}">{{$product->after_discount}}</span></span>
                                                            <del> {{$product->product_price}}</del>
                                                        </div>
                                                        <hr>

                                                        <div class="item_attribute">
                                                                <div class="row">
                                                                    <div class="col col-md-6">
                                                                        <div class="select_option clearfix">
                                                                            <h4 class="input_title">Color *</h4>
                                                                            <select data-id="{{$product->id}}" class="form-control choose_colors" id="color_id" name="color_id">
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
                                                                            <select id="size_ids{{$product->id}}" class="form-control size_ids" name="size_id">
                                                                                <option class="form-control">Choose a Size</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>

                                                            <div class="quantity_wrap">
                                                                <div class="quantity_input">
                                                                    <button type="button" class="input_number_decrementnew" data-productidnew="{{$product->id}}">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                    <input class="input_numbernew{{$product->id}}" type="text" value="1"  name="quantity">
                                                                    <button type="button" class="input_number_incrementnew" data-productidnew="{{$product->id}}">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="total_price">Total: TK <span id="totalnew{{$product->id}}">{{$product->after_discount}}</span></div>
                                                            </div>

                                                            <ul class="default_btns_group ul_li">
                                                                @auth('customerlogin')
                                                                    <li class="stocks{{$product->id}}">
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
                                            @empty
                                            <div class="ps-5">
                                                <h3>No Search Product Found</h3>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{$products->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product_section - end

            ================================================== -->

@endsection

@section('footer_script')

<script>
    $('.brand_name').click(function (){
        a();
    });
    $('.category_id').click(function (){
        a();
    });
    $('.subcategory_id').click(function (){
        a();
    });
    $('.color_id').click(function (){
        a();
    });
    $('.size_id').click(function (){
        a();
    });
    $('#price_range').bind('mouseleave', function(){
        a();
    });
    $('#sort').change(function (){
        a();
    });

    var a = () => {
        var search_input = $('#search_input').val();
        var brand_name = $('input[class="brand_name"]:checked').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var subcategory_id = $('input[class="subcategory_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var price_range = $('#price_range').val();
        var sort = $('#sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&brand_name="+brand_name+"&category_id="+category_id+"&subcategory_id="+subcategory_id+"&color_id="+color_id+"&size_id="+size_id+"&price_range="+price_range+"&sort="+sort;
        window.location.href = link;
    };
</script>

{{-- slider range js --}}
<script>
    $( function() {
      $( "#slider-range" ).slider({
        range: true,
        min: 100,
        max: 600000,
        values: [ 100, 200000 ],
        slide: function( event, ui ) {
          $( "#price_range" ).val(ui.values[ 0 ] + "-" + ui.values[ 1 ] );
        }
      });
      $( "#price_range" ).val( $( "#slider-range" ).slider( "values", 0 ) +
        " -" + $( "#slider-range" ).slider( "values", 1 ) );
    } );
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
       // get size for 1st quick view
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
    // get size for 2nd quick view
    $('.choose_colors').change(function(){
            var color_id = $(this).val();
            var product_id = $(this).attr('data-id');

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
    $('.sizes_id').change(function(){
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
