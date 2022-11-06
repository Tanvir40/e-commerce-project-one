@extends('layouts.dashboard')
@section('content')
@can('edit_product')


{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Product</a></li>
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
                    <form action="{{url('/product/update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{$product->id}}">
                        <div class="row">
                            <div class="col-lg-4 mt-">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Category</label>
                                    <select class="form-control" name="category_id" id="category">
                                        <option value="">-- select --</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{($category->id == $product->category_id?'selected':'')}}>{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 mt-">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Subcategory</label>
                                    <select class="form-control" name="subcategory_id" id="subcategory">
                                        <option value="">-- select --</option>
                                        @foreach ($subcategories as $subcategory)
                                        <option value="{{$subcategory->id}}" {{($subcategory->id == $product->subcategory_id?'selected':'')}}>{{$subcategory->subcategory_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-">
                                <div class="form-group">
                                    <label for="" class="form-label">Select Product Childcategory</label>
                                    <select class="form-control" name="childcategory_id" id="childcategory">
                                        <option value="">-- select --</option>
                                        @foreach ($childcategories as $childcategory)
                                        <option value="{{$childcategory->id}}" {{($childcategory->id == $product->childcategory_id?'selected':'')}}>{{$childcategory->childcategory_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="{{$product->product_name}}">
                                    @error('product_name')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Price</label>
                                    <input type="number" class="form-control" name="product_price" value="{{$product->product_price}}">
                                    @error('product_price')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">After discount Product Price</label>
                                    <input type="number" class="form-control" name="after_discount" value="{{$product->after_discount}}" readonly>
                                    @error('product_price')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Discount %</label>
                                    <input type="number" class="form-control" name="discount" value="{{$product->discount}}">
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Short Description</label>
                                    <input type="text" class="form-control" name="short_desp" value="{{$product->short_desp}}">
                                    @error('short_desp')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Brand Name</label>
                                    <select class="form-control" name="brand_name">
                                        <option value="No Brand">-- No Brand --</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{$brand->brand_name}}" {{($brand->brand_name == $product->brand_name?'selected':'')}}>{{$brand->brand_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_name')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Long Description</label>
                                    <textarea cols="30" rows="10" id="summernote" class="form-control" name="long_desp" value="{!!$product->long_desp!!}"></textarea>
                                    @error('long_desp')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Additional information</label>
                                    <textarea cols="30" rows="10" id="summernote2" class="form-control" name="addi_info" value="{!!$product->addi_info!!}"></textarea>
                                    @error('addi_info')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2 mt-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Preview</label>
                                    <input type="file" class="form-control mb-2" name="preview">
                                    @error('preview')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                    <img width="100" src="{{asset('uploads/products/preview')}}/{{$product->preview}}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2 mt-3 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Product Thumbnails</label>
                                    <input type="file" class="form-control mb-2" name="thumbnail[]" multiple>
                                    @error('thumbnail')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                    @enderror
                                    @foreach ($all_thumbnails as $thum_img)
                                    <img width="100" src="{{asset('uploads/products/thumbnails')}}/{{$thum_img->thumbnail}}" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection

@section('footer_script')
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
