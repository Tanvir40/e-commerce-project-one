@extends('frontend.master')
@section('content')

                <div class="container py-5">
                    <div class="row">
                        <div class="col-lg-8  m-auto my-5">
                            <div class="card">
                                <div class="card-header">
                                    <p>Order Confirmation</p>
                                </div>
                                <div class="card-body">
                                    @if (session('order_success'))
                                        <div class="alert alert-success">
                                            <h5>{{session('order_success')}}</h5>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
