@extends('layouts.dashboard')
@section('content')
{{-- @can('show_reviews') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer Review</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h2>Customer Review List</h2>
              </div>
            <div class="card-body">

                    <div class="table-responsive" id="no-more-tables">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Image</th>
                            <th>User Name</th>
                            <th>Product Name</th>
                            <th>Order Id</th>
                            <th>Review</th>
                            <th>Star</th>
                            <th>Reviewed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $key=>$review)
                        <tr>
                            <td data-title="SL">{{$reviews->firstitem()+$key}}</td>
                            <td data-title="Product Image"><img title="contact-img" class="rounded me-3" height="48" src="{{asset('/uploads/products/preview')}}/{{$review->rel_to_product->preview}}"></td>
                            <td data-title="User Name">{{$review->rel_to_customer->name}}</td>
                            <td data-title="Product Name">{{$review->rel_to_product->product_name}}</td>
                            <td data-title="Order Id">{{$review->order_id}}</td>
                            <td data-title="Review">{{$review->review}}</td>
                            <td data-title="Star">{{$review->star}} Star</td>
                            <td data-title="Reviewed">{{$review->updated_at->format('d/m/Y H:i A')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                {{$reviews->links()}}

            </div>
            </div>
        </div>
        {{-- @endcan --}}
@endsection
