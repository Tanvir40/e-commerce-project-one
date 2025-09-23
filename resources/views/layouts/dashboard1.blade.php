<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tonmoy - Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
	<link rel="stylesheet" href="{{asset('/backend/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('/backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link href="{{asset('/backend/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('/backend/css/style.css')}}" rel="stylesheet">
    <!-- include summernote css/js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header p-4">
            <a href="{{route('home')}}" class="brand-logo'">
                <img class="logo-abbr" src="{{asset('/backend/images/logo.png')}}" alt="">
                <img class="logo-compact" src="{{asset('/backend/images/logo-text.png')}}" alt="">
                <img class="brand-title" src="{{asset('/backend/images/logo-text.png')}}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->



		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">

                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">

                                    @if (Auth::user()->profile_photo == 'default.png')
                                     <img src="{{Avatar::create(Auth::user()->name)->toBase64();}}" alt="">
                                     @else
                                     <img src="{{asset('/uploads/users')}}/{{Auth::user()->profile_photo}}" width="20" alt=""/>
                                    @endif
                                        @php
                                            $name = auth()->user()->roles->pluck('name')[0];
                                        @endphp
									<div class="header-info">
										<span class="text-black"><strong>{{Auth::user()->name}}</strong></span>
										<p class="fs-12 mb-0"><b>{{$name}}</b></p>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{route('profile')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    {{-- <a href="./email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ml-2">Inbox </span>
                                    </a> --}}
                                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();
									document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout</span>
                                    </a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a href="{{route('home')}}">
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li>

                 {{-- @can('role_manager') --}}
                    <li><a href="{{route('role.management')}}">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Role Manager</span>
                        </a>
                    </li>
                {{--@endcan

                @can('dashboard_link_show') --}}

                     {{-- site customization --}}
					<li><a href="{{route('site.customization')}}">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Site Customization</span>
					</a>
                    </li>

                    {{-- order --}}
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Orders Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('pending.orders')}}">Pending Orders</a></li>
                        <li><a href="{{route('processing.orders')}}">Processing Orders</a></li>
                        <li><a href="{{route('delivered.orders')}}">Delivered Orders</a></li>
                        <li><a href="{{route('cencel.orders')}}">Cencel Orders</a></li>
                    </ul>
                    </li>
                    {{-- order --}}

                    {{-- photos and banner --}}
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Banner Photos</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="{{route('add.banner.photos')}}">Add Banner Photos</a></li>
					</ul>
				    </li>




                    {{-- User --}}

                            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-381-television"></i>
                                <span class="nav-text">Users</span>
                            </a>
                            <ul aria-expanded="false">

                                <li><a href="{{route('user')}}">User List</a></li>
                                <li><a href="{{route('user.add.index')}}">Add User</a></li>

                            </ul>
                            </li>

                    {{-- Category --}}

					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Category</span>
					</a>
					<ul aria-expanded="false">

						<li><a href="{{route('add.category')}}">Add Category</a></li>
						<li><a href="{{route('category.trash')}}">Trash Category</a></li>

					</ul>
				    </li>

                    {{-- subcategory --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Sub-Category</span>
					</a>
					<ul aria-expanded="false">

						<li><a href="{{route('add.sub.category')}}">Add SubCategory</a></li>
						<li><a href="{{route('trash.sub.category')}}">Trash Subcategory</a></li>

					</ul>
				    </li>

                    {{-- childcategory --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Child-Category</span>
					</a>
					<ul aria-expanded="false">

						<li><a href="{{route('add.child.category')}}">Add ChildCategory</a></li>
						<li><a href="{{route('trash.child.category')}}">Trash Childcategory</a></li>

					</ul>
				    </li>

                    {{-- Brand --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Brand Creation</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="{{route('add.brand')}}">Add Brand</a></li>
					</ul>
				    </li>

                    {{-- Inventory --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Inventory</span>
					</a>
					<ul aria-expanded="false">

						<li><a href="{{route('add.color.size')}}">Add color and size</a></li>

					</ul>
				    </li>

                    {{-- Add product --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Products-Add</span>
					</a>
					<ul aria-expanded="false">

						<li><a href="{{route('add.product')}}">Add Product</a></li>
						<li><a href="{{route('product.list')}}">Product List</a></li>

					</ul>
				    </li>

                    {{-- Add coupon --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Coupon</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="{{route('coupon')}}">Add Coupon</a></li>
					</ul>
				    </li>


                    {{-- promotion --}}

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-television"></i>
						<span class="nav-text">Promotions</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="{{route('sms.promotion')}}">SMS Promotion</a></li>
						<li><a href="{{route('email.promotion')}}">Email Promotion</a></li>
					</ul>
				    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Customer Handeling</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('customer.list')}}">Customer List</a></li>
                        <li><a href="{{route('show.reviews')}}">Customer Reviews</a></li>
                        <li><a href="{{route('customer.form.view')}}">Customer Forms</a></li>
                    </ul>
                    </li>

                    {{-- @endcan --}}

                </ul>

			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				@yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
	  <!-- jquery -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	  <!-- sweet alert 2 -->
	  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Required vendors -->
    <script src="{{asset('/backend//vendor/global/global.min.js')}}"></script>
	<script src="{{asset('/backend//vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('/backend//vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('/backend//js/custom.min.js')}}"></script>
	<script src="{{asset('/backend//js/deznav-init.js')}}"></script>
	<script src="{{asset('/backend//vendor/owl-carousel/owl.carousel.js')}}"></script>
    <script src="https://cdnjs.com/libraries/Chart.js"></script>

	<!-- Chart piety plugin files -->
    <script src="{{asset('/backend//vendor/peity/jquery.peity.min.js')}}"></script>

	<!-- Dashboard 1 -->
	<script src="{{asset('/backend//js/dashboard/dashboard-1.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:30,
				nav:false,
				dots: false,
				left:true,
				navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
				responsive:{
					0:{
						items:1
					},
					484:{
						items:2
					},
					882:{
						items:3
					},
					1200:{
						items:2
					},

					1540:{
						items:3
					},
					1740:{
						items:4
					}
				}
			})
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000);
		});
	</script>

    @yield('footer_script')
</body>
</html>
