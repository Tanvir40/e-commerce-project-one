@extends('layouts.dashboard')
@section('content')
{{-- @can('show_product_list') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">product List</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row full-width">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="m-auto">product List</h2>
                     <a href="{{route('add.product')}}" class="btn btn-danger float-end btn-sm"><i class="mdi mdi-plus-circle "></i> Add Products</a>
                    @if (session('success'))
                        <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>SL</td>
                        <td>Product Image</td>
                        <td>Product Name</td>
                        <th>Category</th>
                        <th>Added Date</th>
                        <td>Product Price</td>
                        <td>Discount %</td>
                        <td>After Discount</td>
                        <th>Quantity</th>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                        @foreach($all_products as $key=>$product)
                        <tr>
                            <td data-title="SL">{{$key+1}}</td>
                            <td data-title="Product Image">
                                <img src="{{asset('/uploads/products/preview')}}/{{$product->preview}}" alt="contact-img" title="contact-img" class="rounded me-3" height="48">
                                @php
                                    $sum_star = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->sum('star');

                                    $review_count = App\Models\Orderproduct::where('product_id', $product->id)->whereNotNull('review')->count();
                                        if($review_count == 0){
                                            $avg = 0;
                                        }else {
                                            $avg = round($sum_star / $review_count);
                                        }
                                @endphp
                                <p class="m-0 d-inline-block align-middle font-16">
                                    <br>
                                    @for ($i=1; $i<=$avg; $i++)
                                        <span class="text-warning mdi mdi-star"></span>
                                    @endfor
                                </p>
                            </td>
                            <td data-title="Product Name">{{$product->product_name}}</td>
                            <td data-title="Category">{{$product->first()->rel_to_cat->category_name}}</td>
                            <td data-title="Product Name">{{$product->created_at->format('d/m/Y')}}</td>
                            <td data-title="Product Price">{{$product->product_price}}</td>
                            <td data-title="Discount %">{{$product->discount}}</td>
                            <td data-title="After Discount">{{$product->after_discount}}</td>
                            <td data-title="Quantity">{{$product->inventories->sum('quantity')}}</td>
                            <td data-title="Status">
                                <span class="badge bg-success">Active</span>
                            </td>

                            <td class="table-action" data-title="Action">
                                {{-- @can('show_inventory') --}}
                                <a href="{{route('product.inventory' , $product->id)}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                {{-- @endcan

                                @can('edit_product') --}}
                                <a href="{{route('edit.product' , $product->id)}}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                {{-- @endcan

                                @can('del_product') --}}
                                <button type="button" name="{{route('product.delete' , $product->id)}}" class="action-icon delete"> <i class="mdi mdi-delete"></i></button>
                                {{-- @endcan --}}
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endcan --}}
@endsection

@section('footer_script')

 {{-- delete color success --}}
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
