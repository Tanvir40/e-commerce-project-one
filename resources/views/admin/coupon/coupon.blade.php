@extends('layouts.dashboard')
@section('content')
@can('show_coupon')
            {{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif
                @if (session('edit'))
                    <div class="alert alert-success"><strong>{{session('edit')}}</strong></div>
                @endif
                @if (session('exist'))
                    <div class="alert alert-warning"><strong>{{session('exist')}}</strong></div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive" id="no-more-tables">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Coupon Name</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($coupons as $key=>$coupon)
                    <tr>
                        <td data-title="SL">{{$key+1}}</td>
                        <td data-title="Coupon Name">{{$coupon->coupon_name}}</td>
                        <td data-title="Discount">{{$coupon->discount}}</td>
                        <td data-title="Type">{{$coupon->type}}</td>
                        <td data-title="Validity">{{$coupon->validity}}</td>
                        <td data-title="Action">
                            @can('edit_coupon')
                            <a href="{{route('coupon.edit', $coupon->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                            @endcan
                            @can('del_coupon')
                            <button type="button" name="{{route('coupon.delete', $coupon->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button></td>
                            @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>

        @can('add_coupon')

        <div class="col-lg-4">
            <div class="card">
              <div class="card-header">
                  <h3>Add Coupon</h3>
              </div>
              <div class="card-body">
                  <form action="{{url('/coupon/insert/')}}" method="POST">
                      @csrf
                <div class="form-group">
                    <label for="" class="form-label">Coupon Name</label>
                    <input type="text" class="form-control" name="coupon_name">
                        @error('coupon_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Coupon Discount</label>
                    <input type="text" class="form-control" name="discount">
                    @error('discount')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="">-- select option --</option>
                        <option value="percentage">Percentage</option>
                        <option value="amount">Amount</option>
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

          <div class="col-lg-6 m-auto">
            <div class="card">
              <div class="card-header">
                  <h3>Upto Coupon Discount Price</h3>
              </div>
              <div class="card-body">
                  <form action="{{url('coupon/insert/')}}" method="POST">
                      @csrf
                <div class="form-group">
                    <label for="" class="form-label">Coupon Name</label>
                    <input type="text" class="form-control" name="coupon_name">
                        @error('coupon_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                </div>
                <div class="form-group">

                    <div class="row">

                        <div class="col-lg-4">
                            <label for="" class="form-label"> 1st Amount</label>
                            <input type="text" class="form-control" name="amountone">
                            @error('amountone')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 2nd Amount</label>
                            <input type="text" class="form-control" name="amounttwo">
                            @error('amounttwo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">1st Discount</label>
                            <input type="text" class="form-control" name="discountone">
                            @error('discountone')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>

                        <div class="col-lg-4">
                            <label for="" class="form-label"> 3rd Amount</label>
                            <input type="text" class="form-control" name="amountthree">
                            @error('amountthree')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 4th Amount</label>
                            <input type="text" class="form-control" name="amountfour">
                            @error('amountfour')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">2nd Discount</label>
                            <input type="text" class="form-control" name="discounttwo">
                            @error('discounttwo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 5th Amount</label>
                            <input type="text" class="form-control" name="amountfive">
                            @error('amountfive')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 6th Amount</label>
                            <input type="text" class="form-control" name="amountsix">
                            @error('amountsix')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">3rd Discount</label>
                            <input type="text" class="form-control" name="discountthree">
                            @error('discountthree')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 7th Amount</label>
                            <input type="text" class="form-control" name="amountseven">
                            @error('amountseven')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label"> 8th Amount</label>
                            <input type="text" class="form-control" name="amounteight">
                            @error('amounteight')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="col-lg-4">
                            <label for="" class="form-label">4th Discount</label>
                            <input type="text" class="form-control" name="discountfour">
                            @error('discountfour')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">-- select option --</option>
                            <option value="upto">Upto</option>
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
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Upto Coupon Price</button>
                </div>
            </form>
                </div>
            </div>
          </div>

          @endcan


    </div>
@endcan
@endsection

@section('footer_script')

{{-- coupon deleted --}}
<script>
    $('.delete').click(function(){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
           var link = $(this).attr('name');
           window.location.href =link;
        }
        })
    })
</script>
@if(session('delete'))
<script>
    Swal.fire(
      'Deleted!',
      '{{session('delete')}}',
      'success'
    )
</script>
@endif

@endsection
