@extends('frontend.master')
@section('content')
 <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="{{route('index')}}">Home</a></li>
                        <li>Product Details</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->

            <!-- product_details - start
            ================================================== -->
            <section class="product_details section_space pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="product_details_image">
                                <div class="details_image_carousel">
                                    @foreach (App\Models\Thumbnails::where('product_id' , $product_info->id)->get() as $thumbnail)
                                        <div class="slider_item">
                                            <img src="{{asset('/uploads/products/thumbnails')}}/{{$thumbnail->thumbnail}}" alt="image_not_found">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="details_image_carousel_nav">
                                    @foreach (App\Models\Thumbnails::where('product_id' , $product_info->id)->get() as $thumbnail)
                                        <div class="slider_item">
                                            <img src="{{asset('/uploads/products/thumbnails')}}/{{$thumbnail->thumbnail}}" alt="image_not_found">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <form action="{{route('cart.store')}}" method="POST">
                                @csrf
                            <div class="product_details_content">
                                <h2 class="item_title">{{$product_info->product_name}}</h2>
                                <input type="hidden" name="product_id" value="{{$product_info->id}}">
                                <h5>{{$product_info->short_desp}}</h5>
                               <p><strong>Brand :</strong> {{$product_info->brand_name}}</p>
                                @php
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
                                    <span class="review_value">{{$avg}} Rating(s)</span>
                                </div>

                                <div class="item_price">
                                    <span>TK <span id="price">{{$product_info->after_discount}}</span></span>
                                    <del class="text-danger">{{$product_info->product_price}}</del>
                                </div>
                                <hr>

                                <div class="item_attribute">
                                        <div class="row">

                                            <div class="col col-md-6">
                                                <div class="select_option clearfix">
                                                    <h4 class="input_title">Color *</h4>
                                                    <select id="color_id" name="color_id" class="form-control">
                                                        <option class="form-control" value="">Choose a Color</option>
                                                        @foreach ($available_color as $color)
                                                        <option value="{{$color->color_id}}">
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
                                                    @error('color_id')
                                                        <strong class="text-danger">{{$message}}</strong>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col col-md-6">
                                                <div class="select_option clearfix">
                                                    <h4 class="input_title">Size *</h4>
                                                    <select id="size_id" name="size_id" class="form-control">
                                                        <option value="">Choose a Size</option>
                                                    </select>
                                                        @error('size_id')
                                                            <strong class="text-danger">{{$message}}</strong>
                                                        @enderror
                                                </div>
                                            </div>
                                        </div>
                                                @if(session('cart_required'))
                                                    <div class="alert alert-warning">{{session('cart_required')}}</div>
                                                @endif
                                    </div>

                                    <div class="quantity_wrap">
                                        <div class="quantity_input">
                                            <button type="button" class="input_number_decrement">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input class="input_number" type="text" value="1" name="quantity">
                                            <button type="button" class="input_number_increment">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="total_price">Total: TK <span id="total">{{$product_info->after_discount}}</span></div>
                                    </div>

                                    <ul class="default_btns_group ul_li">
                                        @auth('customerlogin')
                                                <li class="stock">
                                                    <button class="btn btn-primary addtocart_btn"   type="submit">Add To Cart</button>
                                                </li>
                                        @else
                                                <li>
                                                    <a class="btn btn_primary addtocart_btn" href="{{route('customer.register')}}">Add To Cart</a>
                                                </li>
                                        @endauth
                                    </form>
                                        <div >
                                            <form action="{{route('wishlist.store')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product_info->id}}">
                                                @auth('customerlogin')
                                                    @if (App\Models\Inventory::where('product_id' , $product_info->id)->sum('quantity') == 0)
                                                    @else
                                                        <button class="btn addtocart_btn" type="submit">Add to Favourite</button>
                                                    @endif
                                            </form>
                                                @else
                                               <a  class="btn addtocart_btn" href="{{route('customer.register')}}">Add To Favourite</a>
                                                @endauth
                                        </div>
                                    </ul>
                                </div>

                        </div>
                    </div>

                    <div class="details_information_tab">
                        <ul class="tabs_nav nav ul_li" role=tablist>
                            <li>
                                <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button" role="tab" aria-controls="description_tab" aria-selected="true">
                                Description
                                </button>
                            </li>
                            <li>
                                <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button" role="tab" aria-controls="additional_information_tab" aria-selected="false">
                                Additional information
                                </button>
                            </li>
                            <li>
                                <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab" aria-controls="reviews_tab" aria-selected="false">
                                Reviews({{$review_count}})
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                                {!!$product_info->long_desp!!}

                            </div>

                            <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                                {!!$product_info->addi_info!!}
                            </div>

                            <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                                <div class="average_area">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 order-last">
                                            <div class="average_rating_text">
                                                <ul class="rating_star ul_li_center">
                                                    @for ($i=1; $i<=$avg; $i++)
                                                    <li><i class="fa fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                                <p class="mb-0">
                                                Average Star Rating: <span>{{($review_count == 0)?'0':$review_count}} out of 5</span> ({{$review_count}} vote)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="customer_reviews">
                                    <h4 class="reviews_tab_title">{{$review_count}} reviews for this product</h4>
                                    @foreach ($reviews as $review)
                                        <div class="customer_review_item clearfix">
                                            <div class="customer_image">
                                                <img src="{{asset('front/images/team/team_1.jpg')}}" alt="image_not_found">
                                            </div>
                                            <div class="customer_content">
                                                <div class="customer_info">
                                                    <ul class="rating_star ul_li">
                                                        @for ($i=1;  $i<=$review->star; $i++)
                                                            <li><i class="fa fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                    <h4 class="customer_name">{{$review->rel_to_customer->name}}</h4>
                                                    <span class="comment_date">{{$review->updated_at->format('M-d-Y')}}</span>
                                                </div>
                                                <p class="mb-0">{{$review->review}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @auth('customerlogin')
                                    @if (App\Models\Orderproduct::where('user_id' , Auth::guard('customerlogin')->id())->where('product_id' , $product_info->id)->exists())
                                        @if (App\Models\OrderProduct::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->where('review', '!=', null)->first() == false)

                                            <div class="customer_review_form">
                                                <h4 class="reviews_tab_title">Add a review</h4>
                                                <form action="{{route('review.insert')}}" method="POST">
                                                    @csrf
                                                    <div class="your_ratings">
                                                        <h5>Your Ratings:</h5>

                                                        <button type="button" class="star" value="1"><i class="fa fa-star-o"></i></button>
                                                        <button type="button" class="star" value="2"><i class="fa fa-star-o"></i></button>
                                                        <button type="button" class="star" value="3"><i class="fa fa-star-o"></i></button>
                                                        <button type="button" class="star" value="4"><i class="fa fa-star-o"></i></button>
                                                        <button type="button" class="star" value="5"><i class="fa fa-star-o"></i></button>
                                                        @error('star')
                                                            <strong class="text-danger">{{$message}}</strong>
                                                        @enderror
                                                    </div>
                                                    <div class="form_item">
                                                        <textarea name="review" placeholder="Your Review*"></textarea>
                                                        @error('review')
                                                            <strong class="text-danger">{{$message}}</strong>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="id" value="{{$product_info->id}}">
                                                    <input type="hidden" name="star" id="star">
                                                    <button type="submit" class="btn btn_primary">Submit Now</button>
                                                </form>
                                            </div>
                                        @else
                                        <div class="alert alert-info">
                                            You Already Review This Product
                                        </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            You Need to BUY This Product to give review
                                        </div>
                                    @endif
                                @else
                                <div class="alert alert-info">
                                    Please Login to give review--> <a href="{{route('customer.register')}}" class="btn btn-primary">Login</a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product_details - end
            ================================================== -->
<br><br><br>
            <!-- related_products_section - start
            ================================================== -->
            <section class="related_products_section section_space">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="best-selling-products related-product-area">
                                <div class="sec-title-link">
                                    <h3>Related products</h3>
                                    <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a></div>
                                </div>
                                <div class="product-area clearfix">
                                    @forelse ($related_product as $related)
                                    <div class="grid">
                                        <div class="product-pic">
                                            <img src="{{asset('/uploads/products/preview')}}/{{$related->preview}}" alt>
                                            <div class="actions">
                                                <ul>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Favourite</title> <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Shuffle</title> <path d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7"/> <path d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17"/> <path d="M19 4L22 7L19 10"/> <path d="M19 13L22 16L19 19"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup" role="button" tabindex="0"><svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Visible (eye)</title> <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/> <circle cx="12" cy="12" r="3"/> </svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <h4><a href="{{route('product.details', $related->id)}}">{{$related->product_name}}</a></h4>
                                            <p><a href="{{route('product.details', $related->id)}}">{{$related->short_desp}}</a></p>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol">TK </span>{{$related->after_discount}}
                                                        </bdi>
                                                    </span>
                                                </ins>
                                            </span>
                                            <div class="add-cart-area">
                                                <form action="{{route('wishlist.store')}}" method="POST">
                                                    @csrf
                                                    @auth('customerlogin')
                                                    <button class="btn btn_primary " type="submit">Add to Favourite</button>
                                                    @else
                                                    <a class="btn btn_primary" href="{{route('customer.register')}}">Add to Favourite</a>
                                                    @endauth
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <h4>No Releted Product Found</h4>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- related_products_section - end
            ================================================== -->
@endsection

@section('footer_script')
<script>

    //total price calculate
    var quantity = $('.input_number').val();
    $('.input_number_increment').click(function(){
        if(quantity < +{{$out_stock_quantity}}
        ){
            quantity++
        }


        $('.input_number').val(quantity);
        var price = $('#price').html();
        var total = price*quantity;
        $('#total').html(total);
    });
     //total price calculate
     var quantity = $('.input_number').val();
     $('.input_number_decrement').click(function(){
         if(quantity > 1){
            quantity--
         }
        $('.input_number').val(quantity);
        var price = $('#price').html();
        var total = price*quantity;
        $('#total').html(total);
    });
</script>

<script>
    //get size name by ajax in product details
    $('#color_id').change(function(){
        var color_id = $(this).val();
        var product_id = '{{$product_info->id}}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type:'POST',
                    url:'/getSize',
                    data:{'color_id':color_id , 'product_id':product_id},
                    success:function(data){
                        $('#size_id').html(data);
                    }
                });
    });

    // review star select
    $('.star').click(function(){
        var star = $(this).attr('value');
        $('#star').attr('value' , star);
    })
</script>

{{-- get size color id for add to cart ajax --}}
<script>
    $('#size_id').change(function(){
            var size_id = $(this).val();
            var color_id = $('.colr_id').attr('data-col');
            var product_id = '{{$product_info->id}}';

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
                    $('.stock').html(data);
                }
            });
        })
    </script>
@endsection
