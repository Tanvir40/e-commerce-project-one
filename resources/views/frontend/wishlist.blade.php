@extends('frontend.master')
@section('content')
 <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Favourite</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->

            <!-- cart_section - start
            ================================================== -->
            <section class="cart_section section_space">
                @if (App\Models\Wishlist::where('customer_id', Auth::guard('customerlogin')->id())->count() > 0 )
                <div class="container">
                    <div class="cart_table">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th class="text-center">PRICE</th>
                                    <th class="text-center">STOCK STATUS</th>
                                    <th class="text-center">ADD TO CART</th>
                                    <th class="text-center">REMOVE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlists as $wishlist)
                                <tr>
                                    <td>
                                        <div class="cart_product">
                                            <img src="{{asset('/uploads/products/preview/')}}/{{$wishlist->rel_to_product->preview}}" alt="image_not_found">
                                            <h3><a href="shop_details.html">{{$wishlist->rel_to_product->product_name}}</a></h3>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="price_text">TK: {{$wishlist->rel_to_product->after_discount}}</span></td>
                                    <td class="text-center">
                                        <span class="price_text text-success">
                                            @if (App\Models\Inventory::where('product_id' , $wishlist->product_id)->sum('quantity') <= 0) <span class="badge bg-warning">Stock Out</span>
                                            @else
                                            <span class="badge bg-success">Stock In</span>
                                        @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if (App\Models\Inventory::where('product_id' , $wishlist->rel_to_product->id)->sum('quantity') <= 0)
                                        @else
                                            <a href="{{route('product.details', $wishlist->product_id)}}" class="btn btn_primary">Buy Now</a>
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="{{route('wishlist.remove', $wishlist->id)}}" class="remove_btn"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <h3>There are no more items in your Favourite List</h3>
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

