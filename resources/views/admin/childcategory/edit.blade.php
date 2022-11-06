@extends('layouts.dashboard')
@section('content')
@can('edit_childcatagory')


<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Child-category Edit</a></li>
    </ol>
    </div>

    <div class="row">
        <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Edit Child Category</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/childcategory/update')}}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="childcategory_id" value="{{$childcategories_info->id}}">
                            <div class="form-group">
                                <label for="" class="form-label">Select Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">-- Select --</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{($category->id == $childcategories_info->category_id?'selected':'')}}>
                                        {{$category->category_name}}</option>
                                @endforeach
                                </select>
                                @error('category_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                                @if(session('exists'))
                                <strong class="text-danger mt-2">{{session('exists')}}</strong>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Select SubCategory</label>
                                <select name="subcategory_id" class="form-control">
                                    <option value="">-- Select --</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{$subcategory->id}}" {{($subcategory->id == $childcategories_info->subcategory_id?'selected':'')}}>
                                        {{$subcategory->subcategory_name}}</option>
                                @endforeach
                                </select>
                                @error('subcategory_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                                @if(session('exists'))
                                <strong class="text-danger mt-2">{{session('exists')}}</strong>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Child Category Name</label>
                                <input type="text" class="form-control" name="childcategory_name" value="{{$childcategories_info->childcategory_name}}">
                                @error('childcategory_name')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                                @if(session('exist'))
                                <strong class="text-danger mt-2">{{session('exist')}}</strong>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-dark">Update Childcategory</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    @endcan
@endsection
