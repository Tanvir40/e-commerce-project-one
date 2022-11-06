@extends('layouts.dashboard')
@section('content')
@can('edit_coupon')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon-Edit</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">
        @if ($coupons->type == 'upto')
        <div class="col-lg-6 m-auto">
            <div class="card">
              <div class="card-header">
                  <h3>Upto Coupon Discount Price</h3>
                  @if (session('exist'))
                    <div class="alert alert-warning"><strong>{{session('exist')}}</strong></div>
                @endif
              </div>
              <div class="card-body">
                  <form action="{{url('/coupon/update/')}}" method="POST">
                      @csrf
                      <input type="hidden" class="form-control" name="upto_coupon_id" value="{{$coupons->id}}">
                <div class="form-group">
                    <label for="" class="form-label">Coupon Name</label>
                    <input type="text" class="form-control" name="coupon_name" value="{{$coupons->coupon_name}}">
                        @error('coupon_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">

                    <div class="row">

                        <div class="col-lg-4">
                            <label for="" class="form-label"> 1st Amount</label>
                            <input type="text" class="form-control" name="amountone" value="{{$coupons->amountone}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 2nd Amount</label>
                            <input type="text" class="form-control" name="amounttwo" value="{{$coupons->amounttwo}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">1st Discount</label>
                            <input type="text" class="form-control" name="discountone" value="{{$coupons->discountone}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 3rd Amount</label>
                            <input type="text" class="form-control" name="amountthree" value="{{$coupons->amountthree}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 4th Amount</label>
                            <input type="text" class="form-control" name="amountfour" value="{{$coupons->amountfour}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">2nd Discount</label>
                            <input type="text" class="form-control" name="discounttwo" value="{{$coupons->discounttwo}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 5th Amount</label>
                            <input type="text" class="form-control" name="amountfive" value="{{$coupons->amountfive}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 6th Amount</label>
                            <input type="text" class="form-control" name="amountsix" value="{{$coupons->amountsix}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">3rd Discount</label>
                            <input type="text" class="form-control" name="discountthree" value="{{$coupons->discountthree}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 7th Amount</label>
                            <input type="text" class="form-control" name="amountseven" value="{{$coupons->amountseven}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 8th Amount</label>
                            <input type="text" class="form-control" name="amounteight" value="{{$coupons->amounteight}}">
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">4th Discount</label>
                            <input type="text" class="form-control" name="discountfour" value="{{$coupons->discountfour}}">
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <label for="" class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="">-- select option --</option>
                        <option value="upto" {{$coupons->type == 'upto'?'selected':''}}>UpTo</option>
                    </select>
                    @error('type')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Validity</label>
                    <input type="date" class="form-control" name="validity">
                    @error('validity')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Upto Coupon Price</button>
                </div>
            </form>
                </div>
            </div>
        </div>
            @else
            <div class="col-lg-4 m-auto">
                <div class="card">
                <div class="card-header">
                    <h3>Edit Coupon</h3>
                </div>
                <div class="card-body">
                    @if (session('exist'))
                        <div class="alert alert-warning"><strong>{{session('exist')}}</strong></div>
                    @endif
                    <form action="{{url('/coupon/update/')}}" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" name="coupon_id" value="{{$coupons->id}}">
                    <div class="form-group">
                        <label for="" class="form-label">Coupon Name</label>
                        <input type="text" class="form-control" name="coupon_name" value="{{$coupons->coupon_name}}">
                        @error('coupon_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Coupon Discount</label>
                        <input type="text" class="form-control" name="discount" value="{{$coupons->discount}}">
                        @error('discount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">-- select option --</option>
                            <option value="percentage" {{$coupons->type == 'percentage'?'selected':''}}>Percentage</option>
                            <option value="amount" {{$coupons->type == 'amount'?'selected':''}}>Amount</option>
                        </select>
                        @error('type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" class="form-control" name="validity">
                        @error('validity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>
                </form>
                </div>
                </div>
            </div>

         @endif

    </div>
    @endcan
@endsection
