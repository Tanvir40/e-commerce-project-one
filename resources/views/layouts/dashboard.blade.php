@auth

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tonmoy - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/backend/images/favicon.icon')}}">

    <!-- third party css -->
    <link href="{{asset('/backend/css/vendor/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{asset('/backend/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/backend/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('/backend/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="dark-style">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/backend/css/vendor/chartist.min.css')}}">

    
</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="{{route('home')}}" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{asset('/backend/images/logo.png')}}" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('/backend/images/logo_sm.png')}}" alt="" height="16">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{asset('/backend/images/logo-dark.png')}}" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('/backend/images/logo_sm_dark.png')}}" alt="" height="16">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-item">
                        <a href="{{route('home')}}" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    @can('role_manager')

                    <li class="side-nav-item">
                        <a href="{{route('role.management')}}" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span> Role Manager </span>
                        </a>
                    </li>
                    @endcan

                    @can('dashboard_link_show')

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarProjects" aria-expanded="false" aria-controls="sidebarProjects" class="side-nav-link">
                            <i class="uil-briefcase"></i>
                            <span>Back-end Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarProjects">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('user')}}">User List</a></li>
                                <li><a href="{{route('user.add.index')}}">Add User</a></li>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a href="{{route('site.customization')}}" class="side-nav-link">
                            <i class="uil-store"></i>
                            <span> Site Customization </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
                            <i class="uil-envelope"></i>
                            <span> Banner Photos </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.banner.photos')}}">Add Banner Photos</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Orders Management </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEcommerce">
                            <ul class="side-nav-second-level">
                            <li><a href="{{route('all.order')}}">All Orders</a></li>
                                <li><a href="{{route('pending.orders')}}">Pending Orders</a></li>
                                <li><a href="{{route('processing.orders')}}">Processing Orders</a></li>
                                <li><a href="{{route('delivered.orders')}}">Delivered Orders</a></li>
                                <li><a href="{{route('cencel.orders')}}">Cencel Orders</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCategory" aria-expanded="false" aria-controls="sidebarCategory" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span>Category </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCategory">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.category')}}">Add Category</a></li>
						        <li><a href="{{route('category.trash')}}">Trash Category</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Sub" aria-expanded="false" aria-controls="Sub" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Sub-Category </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Sub">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.sub.category')}}">Add SubCategory</a></li>
						        <li><a href="{{route('trash.sub.category')}}">Trash Subcategory</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Child" aria-expanded="false" aria-controls="sidebarChildTasks" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Child-Category </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Child">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.child.category')}}">Add ChildCategory</a></li>
						        <li><a href="{{route('trash.child.category')}}">Trash Childcategory</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Brand" aria-expanded="false" aria-controls="Brand" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Brand Creation </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Brand">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.brand')}}">Add Brand</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Inventory" aria-expanded="false" aria-controls="Inventory" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Inventory </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Inventory">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.color.size')}}">Add Color Size</a></li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Product" aria-expanded="false" aria-controls="Product" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Add-Product </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Product">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('add.product')}}">Add Product</a></li>
						        <li><a href="{{route('product.list')}}">Product List</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{route('coupon')}}" class="side-nav-link">
                            <i class="uil-folder-plus"></i>
                            <span> Coupon </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false" aria-controls="sidebarPages" class="side-nav-link">
                            <i class="uil-copy-alt"></i>
                            <span> Promotions </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('sms.promotion')}}">SMS Promotion</a></li>
						        <li><a href="{{route('email.promotion')}}">Email Promotion</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#Customer" aria-expanded="false" aria-controls="Customer" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span>Customer Handeling </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Customer">
                            <ul class="side-nav-second-level">
                                <li><a href="{{route('customer.list')}}">Customer List</a></li>
                                <li><a href="{{route('show.reviews')}}">Customer Reviews</a></li>
                                <li><a href="{{route('customer.form.view')}}">Customer Forms</a></li>
                            </ul>
                        </div>
                    </li>

                    @endcan
                </ul>


                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">


                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    @if (Auth::user()->profile_photo == 'default.png')
                                    <img class="rounded-circle" src="{{Avatar::create(Auth::user()->name)->toBase64();}}" alt="">
                                    @else
                                    <img class="rounded-circle" src="{{asset('/uploads/users')}}/{{Auth::user()->profile_photo}}" width="20" alt=""/>
                                   @endif
                                       @php
                                           $name = auth()->user()->roles->pluck('name')[0];
                                       @endphp
                                </span>
                                <span>
                                    <span class="account-user-name">{{Auth::user()->name}}</span>
                                    <span class="account-position">{{$name}}</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome {{$name}}</h6>
                                </div>

                                <!-- item-->
                                <a href="{{route('profile')}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <div class="app-search dropdown d-none d-lg-block">
                        <h1>DashBoard</h1>
                    </div>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);"></a>
                                <a href="javascript: void(0);"></a>
                                <a href="javascript: void(0);"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="{{asset('/backend/js/vendor.min.js')}}"></script>
    <script src="{{asset('/backend/js/app.min.js')}}"></script>

    <!-- third party js -->
    <script src="{{asset('/backend/js/vendor/apexcharts.min.js')}}"></script>
    <script src="{{asset('/backend/js/vendor/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('/backend/js/vendor/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- third party js ends -->
	<script src="{{asset('/backend/css/vendor/Chart.bundle.min.js')}}"></script>
    <!-- demo app -->
    <script src="{{asset('/backend/js/pages/demo.dashboard.js')}}"></script>
    <!-- end demo js-->
    	  <!-- sweet alert 2 -->
	  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://cdnjs.com/libraries/Chart.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

      
      @yield('footer_script')
</body>
</html>

@else
<script>window.location = "/admin/my-login";</script>
@endauth
