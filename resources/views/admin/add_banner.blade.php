@extends('layouts.dashboard')
@section('content')

@can('add_banner')

{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Add Banner Images</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}


    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center m-auto">Image Carousel and Product Details</h2>
                    @if (session('carousel_image'))
                        <div class="alert alert-success">{{session('carousel_image')}}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{route('image.Carosuel.insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                     <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Small Orange Text</label>
                                <input type="text" class="form-control" name="small_text">
                                @error('small_text')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Thin Large Text</label>
                                <input type="text" class="form-control" name="thin_large_text">
                                @error('thin_large_text')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Thik Large Text</label>
                                <input type="text" class="form-control" name="thik_large_text">
                                @error('thik_large_text')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Small Title</label>
                                <input type="text" class="form-control" name="small_title">
                                @error('small_title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Price</label>
                                <input type="text" class="form-control" name="price">
                                @error('price')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Discount Price</label>
                                <input type="text" class="form-control" name="discount_price">
                                @error('discount_price')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Product Url</label>
                                <input type="url" class="form-control" name="product_url">
                                @error('product_url')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="">Carousel Image</label>
                                <input type="file" class="form-control" name="carousel_image">
                                @error('carousel_image')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                    </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit"> Add New Image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="m-auto">Image Carousel and Product Details List</h2>
                    @if (session('active'))
                        <div class="alert alert-success"><strong>{{session('active')}}</strong></div>
                    @endif
                    @if (session('deactive'))
                        <div class="alert alert-success"><strong>{{session('deactive')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td>Small Orange Text</td>
                                <td>Thin Large Text</td>
                                <td>Thik Large Text</td>
                                <td>Small Title</td>
                                <td>Price</td>
                                <td>Discount Price</td>
                                <td>Product Url</td>
                                <td>Carousel Image</td>
                                <th>Status</th>
                                <th>Active/Deactive</th>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carousel_image as $key=>$carousel)
                                <tr>
                                    <td data-title="SL">{{$key+1}}</td>
                                    <td data-title="Small Text">{{$carousel->small_text}}</td>
                                    <td data-title="Thin Large Text">{{$carousel->thin_large_text}}</td>
                                    <td data-title="Thik Large Text">{{$carousel->thik_large_text}}</td>
                                    <td data-title="Small Title">{{$carousel->small_title}}</td>
                                    <td data-title="Price">{{$carousel->price}}</td>
                                    <td data-title="Discount Price">{{$carousel->discount_price}}</td>
                                    <td data-title="Product Url">{{$carousel->product_url}}</td>
                                    <td data-title="Carousel Image">
                                        <img src="{{asset('front/images/slider')}}/{{$carousel->carousel_image}}" alt="" title="contact-img" class="rounded me-3" height="48"></td>
                                    <td data-title="Status">
                                        <div class="badge bg-{{$carousel->status == 2?'warning':'success'}}">{{$carousel->status == 2?'Deactive':'Active'}}</div>
                                    </td>
                                @if ($carousel->status == 1)
                                    <td  data-title="Active/Deactive"><a href="{{url('/deactive/carousel/'.$carousel->id)}}" class="btn-sm btn-secondary">Deactive User</a>
                                    </td>
                                @else
                                    <td data-title="Active/Deactive">
                                            <a href="{{url('/active/carousel/'.$carousel->id)}}" class="btn-sm btn-success">Active User</a>
                                    </td>
                                @endif
                                    <td data-title="Action">
                                        <button type="button" name="{{route('banner.delete' , $carousel->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
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

@endcan

@endsection

@section('footer_script')
 {{-- delete banner success --}}
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
