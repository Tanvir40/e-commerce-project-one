@extends('frontend.master')
@section('content')
 <!-- register_section - start
            ================================================== -->
            @auth('customerlogin')
              <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="#">Home</a></li>
                        <li>404 Error</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->

            <!-- start error-404-section -->
            <section class="error-404-section section_space">
                <div class="container">
                    <div class="error-404-area">
                        <h2>404</h2>
                        <div class="error-message">
                            <h3>Oops! Page Not Found!</h3>
                            <p>We’re sorry but we can’t seem to find the page you requested. This might be because you have
                            typed the web address incorrectly.</p>
                            <a href="index.html" class="btn btn_primary">Back to home</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end error-404-section -->
            @else
            <section class="register_section section_space">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <ul class="nav register_tabnav ul_li_center" role="tablist">
                                <li role="presentation">
                                    <button class="active" data-bs-toggle="tab" data-bs-target="#signin_tab" type="button" role="tab" aria-controls="signin_tab" aria-selected="true">Sign In</button>
                                </li>
                                <li role="presentation">
                                    <button data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab" aria-controls="signup_tab" aria-selected="false">Register</button>
                                </li>
                            </ul>
                            @if (session('verified'))
                                <div class="alert alert-success"><strong>{{session('verified')}}</strong></div>
                            @endif
                            @if (session('email_verify'))
                                <div class="alert alert-success"><strong>{{session('email_verify')}}</strong></div>
                            @endif
                            @if (session('need_verify'))
                                <div class="alert alert-warning"><strong>{{session('need_verify')}}</strong></div>
                            @endif
                            @if (session('worng_pass'))
                                <div class="alert alert-danger"><strong>{{session('worng_pass')}}</strong></div>
                            @endif
                            @if (session('exist'))
                                <div class="alert alert-warning"><strong>{{session('exist')}}</strong></div>
                            @endif
                            <div class="register_wrap tab-content">
                                <div class="tab-pane fade show active" id="signin_tab" role="tabpanel">
                                    <form action="{{route('customer.login')}}" method="POST">
                                        @csrf
                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Email*</h3>
                                            <div class="form_item">
                                                <label for="username_input"><i class="fa fa-user"></i></label>
                                                <input id="email" type="email" name="email" placeholder="User email" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Password*</h3>
                                            <div class="form_item">
                                                <label for="password_input"><i class="fa fa-lock"></i></label>
                                                <input id="password" type="password" name="password" placeholder="Password" @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            </div>
                                            <div class="checkbox_item">
                                                <a href="{{route('pass.reset')}}" class="text-dark">Forgot Your Password?</a>
                                            </div>
                                        </div>

                                        <div class="form_item_wrap d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Sign In</button> <br>
                                        </div>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="{{url('/github/redirect')}}" class="btn btn_primary">Github Sign In</a>
                                            <a href="{{url('/google/redirect')}}" class="btn btn_primary">Google Sign In</a>
                                            <a href="{{url('/facebook/redirect')}}" class="btn btn_primary">Facebook Sign In</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="signup_tab" role="tabpanel">
                                    <form action="{{route('customer.insert')}}" method="POST">
                                        @csrf
                                        <div class="form_item_wrap">
                                            <h3 class="input_title">User Name*</h3>
                                            <div class="form_item">
                                                <label for="username_input2"><i class="fa fa-user"></i></label>
                                                <input id="username_input2" type="text" name="name" placeholder="User Name">
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Email*</h3>
                                            <div class="form_item">
                                                <label for="email_input"><i class="fa fa-envelope"></i></label>
                                                <input id="email_input" type="email" name="email" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Password*</h3>
                                            <div class="form_item">
                                                <label for="password_input2"><i class="fa fa-lock"></i></label>
                                                <input id="password_input2" type="password" name="password" placeholder="Password">
                                            </div>
                                        </div>



                                        <div class="form_item_wrap">
                                            <button type="submit" class="btn btn_secondary">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endauth

            <!-- register_section - end
            ================================================== -->
@endsection
