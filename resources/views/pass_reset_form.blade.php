@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>Password-Reset Form</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->


            <div class="container">
                <div class="row mt-3">
                    <div class="col-md-6 m-auto">
                       <form action="{{route('pass.reset.update')}}" method="POST">
                           @csrf
                           <div class="card my-5">
                            <div class="card-header bg-warning">
                                <h3 class="text-dark">Password Reset Form</h3>
                            </div>
                            @if (session('reset_success'))
                                <div class="alert alert-success">{{session('reset_success')}}</div>
                            @endif
                            <div class="card-body">
                                <div class="col-mb-3">
                                    <label for="" class="form-label">New Password</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <input type="hidden" name="reset_token" value="{{$token}}">
                                <br>
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-warning text-dark">Change Password</button>
                                </div>
                            </div>
                        </div>
                       </form>
                    </div>
                </div>
            </div>
@endsection
