@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Password-Reset Request</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->


            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-6 m-auto">
                       <form action="{{route('pass.reset.link')}}" method="POST">
                           @csrf
                           <div class="card my-5">
                            <div class="card-header bg-primary">
                                <h3 class="text-white">Password Reset Request</h3>
                            </div>
                            @if (session('reset_link'))
                                <div class="alert alert-success">{{session('reset_link')}}</div>
                            @endif
                            <div class="card-body">
                                <div class="col-mb-3">
                                    <label for="" class="form-label">Enter Your E-mail Address</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <br>
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-primary">Sent Reset Link</button>
                                </div>
                            </div>
                        </div>
                       </form>
                    </div>
                </div>
            </div>
@endsection
