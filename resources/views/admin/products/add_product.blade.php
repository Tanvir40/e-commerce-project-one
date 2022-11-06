@extends('layouts.dashboard')
@section('content')
@can('add_product')


{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Add Product</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2>Add product</h2>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                    @endif
                    <form action="{{url('/product/insert')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Category</label>
                                    <select class="form-control" name="category_id" id="category">
                                        <option value="">-- select --</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Subcategory</label>
                                    <select class="form-control" name="subcategory_id" id="subcategory">
                                        <option value="">-- select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Childcategory</label>
                                    <select class="form-control" name="childcategory_id" id="childcategory">
                                        <option value="">-- select --</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name">
                                    @error('product_name')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Price</label>
                                    <input type="number" class="form-control" name="product_price">
                                    @error('product_price')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Discount %</label>
                                    <input type="number" class="form-control" name="discount">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Short Description</label>
                                    <input type="text" class="form-control" name="short_desp">
                                    @error('short_desp')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Brand Name</label>
                                    <select class="form-control" name="brand_name" >
                                        <option value="No Brand">-- No Brand --</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{$brand->brand_name}}">{{$brand->brand_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_name')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Long Description</label>
                                    <textarea cols="30" rows="10" id="summernote" class="form-control" name="long_desp"></textarea>
                                    @error('long_desp')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Additional information</label>
                                    <textarea cols="30" rows="10" id="summernote2" class="form-control" name="addi_info"></textarea>
                                    @error('addi_info')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Preview</label>
                                    <input type="file" class="form-control" name="preview">
                                    @error('preview')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Thumbnails</label>
                                    <input type="file" class="form-control" name="thumbnail[]" multiple>
                                    @error('thumbnail')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection

@section('footer_script')

{{-- get category --}}
<script>
    $('#category').change(function(){

        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getSubcategory',
            data:{'category_id': category_id},
            success:function(data){
                $('#subcategory').html(data);
            }
        });

    });


</script>

{{-- get sub category --}}
<script>
            $('#subcategory').change(function(){

            var subcategory_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
            type:'POST',
            url:'/getChildcategory',
            data:{'subcategory_id': subcategory_id},
            success:function(data){
                $('#childcategory').html(data);
            }
            });
        });
</script>

{{-- summernote activation --}}
<script>
    $(document).ready(function() {
  $('#summernote').summernote();
});
</script>
<script>
    $(document).ready(function() {
  $('#summernote2').summernote();
});
</script>



@endsection
